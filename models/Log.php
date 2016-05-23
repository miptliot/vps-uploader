<?php
	namespace vps\uploader\models;

	use Yii;

	/**
	 * @property string $dt
	 * @property string $fileGuid
	 * @property string $message
	 * @property string $status
	 * @property int    $userID
	 *
	 * @property-read [[File]] $file
	 */
	class Log extends \yii\db\ActiveRecord
	{
		/**
		 * @return \yii\db\ActiveQuery
		 */
		public function getFile ()
		{
			return $this->hasOne(File::className(), [ 'guid' => 'fileGuid' ]);
		}

		/**
		 * @inheritdoc
		 */
		public function attributeLabels ()
		{
			return [
				'fileGuid' => Yii::tr('File GUID'),
				'status'   => Yii::tr('Status'),
				'message'  => Yii::tr('Message'),
				'dt'       => Yii::tr('DT'),
				'userID'   => Yii::tr('User ID'),
			];
		}

		/**
		 * @inheritdoc
		 */
		public function rules ()
		{
			return [
				[ [ 'dt' ], 'date', 'format' => 'y-MM-dd HH:mm:ss' ],
				[ [ 'fileGuid', 'message' ], 'trim' ],
				[ [ 'guid' ], 'string', 'length' => [ 1, 100 ] ],
				[ [ 'message' ], 'string' ],
				[ [ 'status' ], 'default', 'value' => File::S_NEW ],
				[ [ 'status' ], 'in', 'range' => [ File::S_DELETED, File::S_ERROR, File::S_NEW, File::S_OK, File::S_UPLOADING ] ],
				[ [ 'userID' ], 'integer' ]
			];
		}

		/**
		 * @inheritdoc
		 */
		public static function tableName ()
		{
			return 'vu_log';
		}
	}