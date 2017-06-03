<?php

/*--------------------------------------------------------------*/
/* Make Application                                             */
/*--------------------------------------------------------------*/

/** @var \Neutrino\Foundation\Bootstrap $bootstrap */
$bootstrap = require_once __DIR__ . '/../bootstrap/app.php';

/** @var \App\Kernels\Http\Kernel $kernel */
$kernel = $bootstrap->make(App\Kernels\Http\Kernel::class);

/**
 * Handle the request
 */
$response = $kernel->handle();

/**
 * Send the response.
 */
$response->send();