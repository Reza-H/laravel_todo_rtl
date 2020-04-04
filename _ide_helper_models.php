<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Permission
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission query()
 */
	class Permission extends \Eloquent {}
}

namespace App{
/**
 * App\Todo
 *
 * @property int $id
 * @property string $name
 * @property string $start_at
 * @property string $end_at
 * @property int $owner_id
 * @property string $type
 * @property int $is_done
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Todo onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereIsDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereStartAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Todo whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Todo withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Todo withoutTrashed()
 */
	class Todo extends \Eloquent {}
}

namespace App{
/**
 * App\UserFriend
 *
 * @property int $id
 * @property int $user_id
 * @property int $friend_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserFriend newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserFriend newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserFriend query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserFriend whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserFriend whereFriendId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserFriend whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserFriend whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\UserFriend whereUserId($value)
 */
	class UserFriend extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $friends
 * @property-read int|null $friends_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Todo[] $todos
 * @property-read int|null $todos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

