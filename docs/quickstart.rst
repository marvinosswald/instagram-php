==========
Quickstart
==========

This page provides a quick introduction to Instagram PHP and introductory examples.
If you have not already installed, Instagram PHP, head over to the :ref:`installation`
page.


Access Instagram API
====================

You can send requests with the SDK using a ``marvinosswald\Instagram\Instagram``
object.


Creating a Client
-----------------

.. code-block:: php

    use marvinosswald\Instagram\Instagram;

    $params = [
        'accessToken' => 'your-access-token',
        'clientId' => 'your-client-id'
        'clientSecret' => 'your-client-secret',
        'redirectUri' => 'your-redirect-uri'
    ]

    $config = [
        'allow_redirects' => false
        'http_errors' => false
        ...
    ];

    $instagram = new Instagram($params, $config);


The client constructor accepts two arrays :
    - $params
    - $config who can contain all GuzzleHttp\Client request options see : http://docs.guzzlephp.org/en/stable/request-options.html

Access Media Endpoint
---------------------

.. code-block:: php

    $media = $instagram->media(MEDIA_ID)->get();
