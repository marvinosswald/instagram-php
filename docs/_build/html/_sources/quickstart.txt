==========
Quickstart
==========

This page provides a quick introduction to Instagram PHP and introductory examples.
If you have not already installed, Instagram PHP, head over to the :ref:`installation`
page.


Access Instagram API
================

You can send requests with the SDK using a ``marvinosswald\Instagram\Instagram``
object.


Creating a Client
-----------------

.. code-block:: php

    use marvinosswald\Instagram\Instagram;

    $instagram = new Instagram(ACCESS_TOKEN);


The client constructor accepts an ACCESS_TOKEN string

Access Media Endpoint
----------------

.. code-block:: php

    $media = $instagram->media(MEDIA_ID)->get();
