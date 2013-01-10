******************************************
How to GET a Cup of Coffee with TYPO3 Flow
******************************************

**Note**: This is still work in progress. Feel free to check it out, but some important parts are still missing.

This contains the TYPO3 Flow package "Wwwision.Starbucks" that implements the simple webservice described at http://www.infoq.com/articles/webber-rest-workflow.
The article is from 2008 and even though it covers timeless and great concepts it also includes some techniques that are obsolete in the meantime.
However with this little experiment I'm not trying to improve the implementation but try to implement it as true to the original as possible to see whether
Flow offers all we need for it.
Thus all credit go to the authors of the article, Jim Webber, Savas Parastatidis & Ian Robinson.

============
Installation
============

**1. Apply a patch:**

First of all you need to apply a patch that has not yet been merged into the core.
The patch contains some convenience methods for REST based applications, see: https://review.typo3.org/#/c/11704/

If you have installed Flow via git, applying the patch is really easy:

::

	cd Packages/Framework/TYPO3.Flow
	git fetch https://review.typo3.org/FLOW3/Packages/TYPO3.FLOW3 refs/changes/04/11704/6 && git cherry-pick FETCH_HEAD

**2. Clone package**

Clone the package to the ``Packages/Application`` directory of your Flow distribution:

::

	git clone git://github.com/bwaidelich/Wwwision.Starbucks.git Wwwision.Starbucks

**3. Include the package Routes**

You can activate the packages sub routes by adding the following snippet *on top* of your ``Configuration/Routes.yaml`` file:

::

	##
	# Wwwision.Starbucks SubRoutes
	#
	-
	 name:        'Wwwision.Starbucks'
	 uriPattern:  '<StarbucksSubroutes>'
	 subRoutes:
	   'StarbucksSubroutes':
	     package: 'Wwwision.Starbucks'

**4. Apply Doctrine migrations:**

Update your database schema by applying all required Doctrine migrations:

::

	./flow doctrine:migrate

**5. Brew some coffee**

Setup some test data by executing

::

	./flow starbucks:setup

This will create some drinks and additions that can be ordered.

=====
Usage
=====

Order coffee
^^^^^^^^^^^^

The first story of the original article is ``As a customer, I want to order a coffee so that Starbucks can prepare my drink``.
If your flow application is accessible via localhost, the corresponding cURL command is

::

	curl -i -H "Accept: application/xml" -H "Content-Type: application/xml" -X POST -d "<root><order><drink>latte</drink></order></root>" http://localhost/order/

.. Note:: As you can see, we need to add a <root> node to the request body (this can be any tag, it is ignored). I consider this a bug in Flow which will probably be fixed soon.

The response should be something like:

**Response**::

	HTTP/1.1 201 Created
	Content-Type: application/vnd.wwwision.starbucks.order+xml

	<?xml version="1.0" encoding="utf-8"?>
	<order self="http://dev.flow.local/order/2a7a6fd9-fa6f-47e2-8976-7c8308a96e4c">
		<drink>Latte</drink>
		<cost>3.00</cost>

		<next xmlns="http://localhost/state-machine"
			rel="http://localhost/payment"
			href="http://dev.flow.local/order/2a7a6fd9-fa6f-47e2-8976-7c8308a96e4c/payment"
			type="application/xml"
		/>
	</order>

Order Additions
^^^^^^^^^^^^^^^

The second story is ``As a customer, I want to be able to change my drink to suit my taste``
The article suggests to check the supported HTTP methods first. This can be done with following request::

	curl -i -X OPTIONS http://dev.flow.local/order/2a7a6fd9-fa6f-47e2-8976-7c8308a96e4c

.. Note:: Replace ``2a7a6fd9-fa6f-47e2-8976-7c8308a96e4c`` with the UUID of the order returned in the previous response (and do the same in the following samples)

**Response**::

	HTTP/1.1 200 OK
	Allow: GET, PUT

Now we can PUT an addition to our order like this::

	curl -i -H "Accept: application/xml" -H "Content-Type: application/xml" -X PUT -d "<root><order><additions>shot</additions></order></root>" http://dev.flow.local/order/2a7a6fd9-fa6f-47e2-8976-7c8308a96e4c


to be continued...
^^^^^^^^^^^^^^^^^^

Sorry, I still need to tweak/work around some issues in Flow in order to finish this example. Stay tuned.