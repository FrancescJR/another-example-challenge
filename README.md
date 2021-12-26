# Collective Minds Rad Technical challenge

Solution with hexagonal architecture, Symfony 6.0 as framework, PHP 8.1
and using DDD principles.

## Requirements

* Docker.
* PHP composer (Check dockerfile on how to install)


### Usage

Execute `composer start` at the root of the project. Make sure you don't 
have anything already listening on port 8000.

#### Create subject

POST http://localhost:8000/subjects/v1/repository/9066f75d-43e1-3966-a068-769b985cc047/subject

(any valid uuid is OK)
with body

```
{
    "id": "a066f75d-43e1-3966-a068-769b985cc04a"
}
```

Try any other valid UUID for a "subject already exists exception".

#### Enroll Subject on Project

PUT http://localhost:8000/subjects/v1/repository/9066f75d-43e1-3966-a068-769b985cc047/project/9066f75d-43e1-3966-a068-769b985cc047

(any valid uuid is OK)
with body

```
{
    "subject_id": "a066f75d-43e1-3966-a068-769b985cc045",
    "subject_type": "control"
}
```

* subject_id: any valid uuid except the one used above, (it is the only uuid that
the "core service" returns a not found.)
* subject_type: one of control/recipient

## Description and decisions

### First some words about the challenge

I really liked the test, it can be done fast (I didn't) and it shows
very nicely how developers work.

But there is a big issue with the description and how it is presented
from my point of view. Taking into account the whole
description, it means that this service is supposed
to be like a way to call another API. AKA a proxy. A proxy it should not have any logic,
especially not domain logic.

I understand that this might be
a temporary solution for moving from a big monolith to independent services
but if that is not the case then
I would strongly recommend against this way of developing APIs. The result
of this is a duplication of maintenance work: the one in the core API
and the one in the proxy, and a source of troubleshooting and bugs.

The domain logic should exist in only one place. If subjects logic is going
to be in this service then it should be removed from the Core API. For instance,
the creation of subjects, shouldn't be in the core API anymore. If you
want to filter data, that should be done in the place where the data to be
filtered actually exists, not somewhere else.

It is very important (and difficult) to define strongly the boundaries of each
service. That would be called a bounded context. And any communication between
bounded contexts should be questioned a lot else it might mean that some
business logic belongs to the same bounded context.

APIs are especially meant to be exposed to external systems (that should apply
to the core API too). The limitations
shouldn't be not making them accessible. The limitations
should be about adding usage limits and authentication and authorization of this usage.
API gateways will give you of the shelf solutions to that, and for the fine-grained
permissions and others that require actual
business knowledge, those can be implemented on the service itself.

API Gateways will allow you also to have the system in an internal network.
If that is the actual fear. (You can just have a proxy for the same, but
insisting again and being very adamant, this proxy should not have any
business logic)

======

Now having said that, these are some explanations of the code:

I hope the code is enough self-explanatory. There are 3 aggregate roots even
though one, the customer repository ID, since it is not required to
create or work on it, I just created the value object id so the other
two aggregates roots can reference to.

There is a bit of business domain logic on the application layer: 
the constraint that
the duplicity of subjects on the same repository is not allowed.
That could be solved by a domain service using the repository, but I
think this is too much over complication just to follow the books, so
I am happy by having this part on the create subject handler command.

The most tricky part of the challenge is the many-to-many relationship
of two aggregates subjects and projects, where subjects are enrolled in
projects. I assumed that a subject can be enrolled in a project as either
control or recipient.

For that reason I though that a good way to solve
it is by creating a new entity, SubjectEnrolled,
that represents the relationship and explains the subject's type.
Having it in an entity it will make it easier to map in a
relational database too. I thought it made more sense to have this list
under project aggregate root.

_**Alternative**: instead of having the function enroll subject
in the project, a domain service could be created for that, that would
easy just a little the command handler test. I am not fond though
of domain services because they eventually lead to anemic models
with non-rich entities._

#### Breaking the rules of aggregates

Taking into account that this is a proxy. It would make more sense
to just call the POST to the core service when enrolling a subject.

With the added domain logic, there is an issue when saving the project
and it is that it can't be saved in a single "transaction". Here transactions
are calls to the core service. And there is a call for each relation.

To make just the call that we want, I could assume that from the core
service, when I get the aggregate project, I get it, of course, with the list
of subjects enrolled, and then make just the repository call to
`enrollProjectOnCoreService` function 
with the exact subject that is being added.
(that's why this function is public,
probably calling that instead of "save" is a better solution than the one
I am sending).That doesn't feel like a natural
function for a repository, and after all, this is implemented on the
infrastructure. Domain logic went all the way to the infra (not that bad
as the other way around). But the whole thing could be prevented by
not using a proxy in the first place and putting the logic in the bounded
context where the domain lives.

#### What if subjects had a list of projects enrolled?

You might have noticed that I don't do anything with subjects when
enrolling a subject in a project. I am maintaining independence of aggregate
roots. Subjects don't even have a list of projects, but what if they had?

That should be solved by triggering a domain event when the subject
is enrolled to the project and have some listeners to act upon this
triggering.

One subscriber could trigger an application service of
adding the project in the project list of the subjects, and save the subjects.

We could even go further and have two different models for subject:
the one that you see (would be the write model) and the read one, and
only this one with the list of projects.

Another subscriber could update just the read model, (just project
the domain event on the read model). The read model could use an infra
faster for get queries like elastic search.

But adding CQRS on a service that is meant to just be a proxy doesn't make
much sense.


## Minor upgrades (TODO list)

### Domain
#### Identity of aggregate roots
Identity for subjects and project could have the repository
id inside, it should, it's just harder to map later to doctrine
or to any other DB though later.

#### Abstract Value Objects
For uuid at least. Current VO to extend from the abstract to avoid code
repetition.

#### Exceptions
Domain and application exceptions. Symfony exception listener for
infrastructure exception and appropriate responses

### Application
#### Command bus
Tactitian or Symfony bus as command bus for some decoration. At this stage
though only the exception treatment can be solved with decoration.
And request validation.

#### Abstract Tests
For controllers and command handlers, and better usage of prophecy
and extendable. Use prophecies as if we had an implementation
of repositories that are shared among handlers.

### Infrastructure
#### Anticorruption layer on the Core Service API
I am assuming that the core service will work as expected and there's little
error handling. A facade plus an implementation to create the domain
objects from the http calls will be nice.

#### framework independent skeleton (big change)
This is using symfony skeleton (directory structure). It would be
nice to put all that symfony need to work under the infrastructure
directory. And have for example Laravel there working too.

### CI/CD
#### Php fpm instead of symfony server
Symfony server is useful because it's fast. But it's a must to have
dev environment as close to prod as possible. Symfony server is not
recommended for production.
