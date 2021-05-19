<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Docno
 *
 * @property int $id
 * @property string $doc_date
 * @property string $doc_type
 * @property string $classification
 * @property string $subject
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Docno newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Docno newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Docno query()
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereDocDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereDocType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $docno
 * @method static \Illuminate\Database\Eloquent\Builder|Docno whereDocno($value)
 */
	class Docno extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Letter
 *
 * @property int $id
 * @property int $docno_id
 * @property int $from_id
 * @property int $to_id
 * @property int $draft_to_id
 * @property string|null $file_path
 * @property string $message
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Docno $docno
 * @property-read \App\Models\User $draftTo
 * @property-read \App\Models\User $from
 * @property-read \App\Models\User $to
 * @method static \Illuminate\Database\Eloquent\Builder|Letter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Letter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Letter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereDocnoId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereDraftToId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereFromId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereToId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereUpdatedAt($value)
 */
	class Letter extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OfficialMemo
 *
 * @property int $id
 * @property int $letter_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $number
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialMemo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialMemo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialMemo query()
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialMemo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialMemo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialMemo whereLetterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialMemo whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OfficialMemo whereUpdatedAt($value)
 */
	class OfficialMemo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\UserAttribute|null $attr
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserAttribute
 *
 * @property int $id
 * @property int $user_id
 * @property string $position
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttribute wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttribute whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserAttribute whereUserId($value)
 */
	class UserAttribute extends \Eloquent {}
}

