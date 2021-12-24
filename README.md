# Requirements


# Usage



## Description and decisions

### Domain

There are three aggregate roots that build the domain, well
actually two, since the customer repository at this point of development
is not needed, we just need the ID to reference it on the other
aggregates. The other two aggregate roots are projects and subjects.

ValueObjects are on the same directory where the entities that use
them live. I separated the custom Exceptions on a sub folder to avoid
cluttering this directory too much, but probably that was unnecessary.

_**upgrade**: create a domain exception and extend domain exceptions
from this one instead of extending from PHP exception._

_**upgrade**: most value objects are about uuid type, an abstract
uuid value object could be created and the main check of checking whether
it is a valid uuid should be done there, avoiding many code repetition._

_**alternative**: Identity for subjects and project could have the repository
id inside, it should, it's just harder to map later to doctrine
or to any other DB though later._

There is a many-to-many relationship between projects and subjects.
I believe both entities should be aggregate roots: subjects can
and should be created independently, as it's shown on the core API
(only the customer repository ID where they belong is needed), and
the exact same for projects.

Also I understood that subjects are enrolled in projects as either
control or recipients.

Taking into account both facts, I created a new entity, SubjectEnrolled,
that represents the relationship and explains the subject's type.
Having it in an entity it will make it easier to map in a 
relational database too.

I decided it makes more sense to make the projects have the list
of this entity (on the SubjectIsEnrolled List). So projects as
an aggregate root have
a list of SubjectsEnrolled entities.

_**Alternative**: instead of having the function enroll subject 
in the project, a domain service could be created for that, that would
easy just a little the command handler test. I am not fond though
of domain services because they eventually lead to anemic models
with non-rich entities._

Subjects have also a list of projects, but being a different
aggregate root, the list will get updated eventually (eventual
consistency) via domain events.

_**upgrade**: CQRS and having a read model for subjects different than the write model
done here. Add the list of projects on the read model and remove
it from the write model: enrolling a subject to a project will
update the read model, but the write model of subjects can keep
without any modification_

_**upgrade**: Continuing with the above we can add event sourcing. We would
have timestamps (well timestamps can also be added
as value objects on the entity too of course)
when the actions happened and the read model will
be updated via projections._

#### Tests

I am using basically unit tests. To test everything I have to add
some tests for the entity that's inside the aggregate root, but 
I hope that by checking the project entity unit test, developer
can understand how are they supposed to execute the domain, and 
mimic it in the application layer.

### Application

The usage of the domain is explained in the domain tests. Application
just mimic the tests and execute the domain as shown in the tests.

There is a bit of business domain logic on this layer: the constraint that
the duplicity of subjects on the same repository is not allowed.
That could be solved by a domain service using the repository, but I 
think this is too much over complication just to follow the books, so
I am happy by having this part on the create subject handler command.

I am not using any command bus at this stage of the development, but that
could be an upgrade.

#### Tests

I am using prophecy here to try to follow the given when then
test structure. Most Command Handlers will work with 
repositories and a cool upgrade would be to have
prophecies repositories prepared for all the handlers, there would be
some reduction of code duplication in that case.



### Infrastructure

I tried to be as independent as possible from the framework
TODO: I am using symfony skeleton, but I want to use
my own skeleton and then put symfony controllers and DI
on infra and also try the laravel controllers and DI in infra.

The implementation of the repositories are in Guzzle calls to
the fake service core.

### CI/CD

Docker Compose for local development, I would just need an image
but I am using the mock image to pretend I am calling
the core service.

I am using symfony service just to go fast, but for production
I would just add an nginx image. Docker compose would also 
use the nginx image. The closer the development environment
is to production the better.


# Comments

## About the big picture

I have been itching a little doing this challenge. Taking into account the whole
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

## About projects and subjects

Seeing the example endpoints of the core service, it feels like
there is a circular reference between projects and subjects.
POST on a project inside a subject and also a POST of a subject
inside a project. I would strongly recommend choosing just one
to simplify the domain greatly (for example, I
just chose that projects have more weight
and that they have subjects inside, then with
eventual consistency we can maybe update subjects,
if they have a list of projects were they belong to,
but is that list really necessary?). And it will be easier to 
maintain API restful constraints.

## About the diagram.

There are two extra numbers on the 
repository subject relationship, I believe those
are leftovers from a previous diagram. The relationship
between projects and subjects, it's specified as at least 1..*
on each direction. That means that a subject can not exist without
a project and vice-versa, a project can not exist without a
subject. I'd recommend changing that to 0..*.

