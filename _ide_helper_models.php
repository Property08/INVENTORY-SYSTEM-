<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Disposable
 *
 * @property int $id
 * @property string $name
 * @property string|null $article
 * @property int $quantity
 * @property string $unit_value
 * @property string $property_number
 * @property string|null $description
 * @property string|null $DateAcquired
 * @property int|null $year
 * @property string $WMR_num
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Disposable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Disposable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Disposable query()
 * @method static \Illuminate\Database\Eloquent\Builder|Disposable whereArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disposable whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disposable whereDateAcquired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disposable whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disposable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disposable whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disposable wherePropertyNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disposable whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disposable whereUnitValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disposable whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disposable whereWMRNum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Disposable whereYear($value)
 */
	class Disposable extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PPERecap
 *
 * @property int $id
 * @property int $record_id
 * @property string|null $acct_code_new
 * @property string|null $acct_code_old
 * @property string|null $classification
 * @property int $year
 * @property string $beginning_balance
 * @property string $purchases
 * @property string $reclass_from
 * @property string $reclass_to
 * @property string $disposed
 * @property string $donated
 * @property string $adjustments
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $total
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap query()
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap whereAcctCodeNew($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap whereAcctCodeOld($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap whereAdjustments($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap whereBeginningBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap whereClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap whereDisposed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap whereDonated($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap wherePurchases($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap whereReclassFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap whereReclassTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap whereRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap whereTotal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PPERecap whereYear($value)
 */
	class PPERecap extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Record
 *
 * @property int $id
 * @property string $title
 * @property string $year
 * @property string|null $pdf_path
 * @property string|null $excel_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PPERecap> $recaps
 * @property-read int|null $recaps_count
 * @method static \Illuminate\Database\Eloquent\Builder|Record newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Record newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Record query()
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereExcelPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record wherePdfPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Record whereYear($value)
 */
	class Record extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Rpcppe
 *
 * @property int $id
 * @property string|null $article
 * @property string|null $description
 * @property string|null $property_no
 * @property string|null $classification
 * @property string|null $unit_value
 * @property string|null $unit_of_measure
 * @property int|null $quantity_per_property_card
 * @property int|null $quantity_per_physical_count
 * @property string|null $remarks
 * @property string|null $date_acquired
 * @property string|null $accountable_person
 * @property string|null $location
 * @property string|null $ptsd
 * @property string|null $division
 * @property string|null $section_unit
 * @property string|null $transfer_to
 * @property int|null $shortage_overage_qty
 * @property string|null $shortage_overage_value
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe query()
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereAccountablePerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereArticle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereClassification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereDateAcquired($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereDivision($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe wherePropertyNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe wherePtsd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereQuantityPerPhysicalCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereQuantityPerPropertyCard($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereSectionUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereShortageOverageQty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereShortageOverageValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereTransferTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereUnitOfMeasure($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Rpcppe whereUnitValue($value)
 */
	class Rpcppe extends \Eloquent {}
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
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
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
 */
	class User extends \Eloquent {}
}

