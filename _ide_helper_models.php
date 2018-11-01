<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Model{
/**
 * App\Model\Wallet
 *
 * @mixin \Eloquent
 */
	class Wallet extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Budget
 *
 * @mixin \Eloquent
 */
	class Budget extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\BudgetCategories
 *
 */
	class BudgetCategories extends \Eloquent {}
}

namespace App\Model{
/**
 * Class User
 *
 * @package App\Model
 * @property-read int $id
 * @property string $email
 * @property string $name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 */
	class User extends \Eloquent {}
}

namespace App\Model{
/**
 * App\Model\Category
 *
 * @mixin \Eloquent
 */
	class Category extends \Eloquent {}
}

