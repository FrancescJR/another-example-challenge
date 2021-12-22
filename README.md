# Requirements


# Usage


# Comments

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

## About the diagram.

There are two extra numbers on the 
repository subject relationship, I believe those
are leftovers from a previous diagram. The relationship
between projects and subjects, it's specified as at least 1..*
on each direction. That means that a subject can not exist without
a project and viceversa, a project can not exist without a
subject. I'd recommend to change that to 0..*.

