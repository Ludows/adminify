<?php

namespace Ludows\Adminify\Models;

use Ludows\Adminify\Models\ClassicAuthUser;

use Spatie\Feed\Feedable;

use Spatie\Searchable\Searchable;
abstract class ClassicUser extends ClassicAuthUser implements Searchable, Feedable
{}
