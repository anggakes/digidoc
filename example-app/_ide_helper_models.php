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
 * App\Models\Cc
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $document_id
 * @property string $email
 * @method static \Illuminate\Database\Eloquent\Builder|Cc newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cc newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cc query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cc whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cc whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cc whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cc whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cc whereUpdatedAt($value)
 */
	class Cc extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Department
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|Department newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Department query()
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Department whereUpdatedAt($value)
 */
	class Department extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DigSign
 *
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign query()
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $data
 * @property int|null $sign_by_id
 * @property string|null $sign_uniqueness
 * @property string $document_id
 * @property string|null $label
 * @property string|null $departement
 * @property string|null $signed_by_name
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign whereDepartement($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign whereSignById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign whereSignUniqueness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign whereSignedByName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DigSign whereUpdatedAt($value)
 */
	class DigSign extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Document
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Document newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Document query()
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $created_by
 * @property string $number
 * @property string $title
 * @property string $status
 * @property string|null $file_path
 * @property int $editable
 * @property string $type
 * @property string $content
 * @property string|null $content_path
 * @property int|null $memo_to_department_id
 * @property int|null $out_recipient_id
 * @property string $classification_code
 * @property int|null $in_recipient_id
 * @property int|null $disposition_to_department_id
 * @property int|null $berita_acara_department_id
 * @property string|null $surat_masuk_date
 * @property string|null $surat_masuk_from
 * @property string|null $surat_keluar_to
 * @property string|null $surat_keluar_type
 * @property string|null $surat_keluar_template
 * @property string|null $surat_address
 * @property string $surat_keluar_name
 * @property string $surat_keluar_email
 * @property string $surat_keluar_phone
 * @property string $surat_keluar_address
 * @property-read \App\Models\Department|null $beritaAcaraDepartment
 * @property-read \App\Models\User $createdBy
 * @property-read \App\Models\ExternalRecipient|null $externalRecipient
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\DocumentFile[] $files
 * @property-read int|null $files_count
 * @property-read \App\Models\Department|null $memoDepartment
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereBeritaAcaraDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereClassificationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereContentPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereDispositionToDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereEditable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereInRecipientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereMemoToDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereOutRecipientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSuratAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSuratKeluarAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSuratKeluarEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSuratKeluarName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSuratKeluarPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSuratKeluarTemplate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSuratKeluarTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSuratKeluarType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSuratMasukDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereSuratMasukFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Document whereUpdatedAt($value)
 */
	class Document extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DocumentAction
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $document_id
 * @property int $is_done
 * @property int $user_id
 * @property string $action_need
 * @property string $note
 * @property string $action_from
 * @property-read \App\Models\Document $document
 * @property-read \App\Models\User $from
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentAction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentAction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentAction query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentAction whereActionFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentAction whereActionNeed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentAction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentAction whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentAction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentAction whereIsDone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentAction whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentAction whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentAction whereUserId($value)
 */
	class DocumentAction extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DocumentClassification
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $code
 * @property string $archive_type
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentClassification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentClassification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentClassification query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentClassification whereArchiveType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentClassification whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentClassification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentClassification whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentClassification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentClassification whereUpdatedAt($value)
 */
	class DocumentClassification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DocumentCodes
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $label
 * @property string $code
 * @property int $seq
 * @property string $type
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCodes newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCodes newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCodes query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCodes whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCodes whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCodes whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCodes whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCodes whereSeq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCodes whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentCodes whereUpdatedAt($value)
 */
	class DocumentCodes extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DocumentFile
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $document_id
 * @property string $path
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFile whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFile wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentFile whereUpdatedAt($value)
 */
	class DocumentFile extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DocumentHistories
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $document_id
 * @property int $user_id
 * @property string $action
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistories query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistories whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistories whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistories whereDocumentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistories whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentHistories whereUserId($value)
 */
	class DocumentHistories extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\DocumentTemplate
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $stub
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTemplate whereStub($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DocumentTemplate whereUpdatedAt($value)
 */
	class DocumentTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ExternalRecipient
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $email
 * @property string $name
 * @property string|null $phone
 * @property string|null $address
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalRecipient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalRecipient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalRecipient query()
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalRecipient whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalRecipient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalRecipient whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalRecipient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalRecipient whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalRecipient wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ExternalRecipient whereUpdatedAt($value)
 */
	class ExternalRecipient extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\JobPosition
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $label
 * @property int $parent_id
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition query()
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $department
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition whereDepartment($value)
 * @property-read JobPosition|null $parent
 * @property int $department_id
 * @property-read JobPosition|null $jobParent
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|JobPosition whereDepartmentId($value)
 */
	class JobPosition extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Letter
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $title
 * @property string|null $file_path
 * @property string $description
 * @property string $type
 * @property string $from
 * @property string $to
 * @property int $uploaded_by
 * @property int $editable
 * @property string $number
 * @method static \Illuminate\Database\Eloquent\Builder|Letter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Letter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Letter query()
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereEditable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereUploadedBy($value)
 * @mixin \Eloquent
 * @property int $from_id
 * @property int $to_id
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereFromId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Letter whereToId($value)
 */
	class Letter extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Memo
 *
 * @property int $id
 * @property string $title
 * @property int $from_id
 * @property int $to_id
 * @property int $draft_to_id
 * @property string|null $file_path
 * @property string $message
 * @property string $status
 * @property int $editable
 * @property string $number
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Memo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Memo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Memo query()
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereDraftToId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereEditable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereFromId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereToId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Memo whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	class Memo extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Template
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Template newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Template newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Template query()
 * @mixin \Eloquent
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $file_path
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Template whereUpdatedAt($value)
 */
	class Template extends \Eloquent {}
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
 * @property int|null $job_position_id
 * @property int $is_admin
 * @method static \Illuminate\Database\Eloquent\Builder|User whereIsAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereJobPositionId($value)
 * @property-read \App\Models\JobPosition|null $job_position
 * @property string $nip
 * @property-read \App\Models\JobPosition|null $jobPosition
 * @method static \Illuminate\Database\Eloquent\Builder|User whereNip($value)
 */
	class User extends \Eloquent {}
}

