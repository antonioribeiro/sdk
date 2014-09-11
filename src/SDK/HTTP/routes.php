<?php

Route::when('*', 'csrf', ['post', 'patch', 'delete', 'put']);
