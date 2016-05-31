<?php
	namespace vps\uploader\models;

	use vps\tools\helpers\TimeHelper;
	use Yii;

	/**
	 * @property string $dt
	 * @property string $extension
	 * @property string $guid
	 * @property string $message
	 * @property string $name
	 * @property string $path
	 * @property string $size
	 * @property string $status
	 * @property int    $userID
	 *
	 * @property-read [[Log]][] $logs
	 */
	class File extends \yii\db\ActiveRecord
	{
		const S_DELETED   = 'deleted';
		const S_ERROR     = 'error';
		const S_NEW       = 'new';
		const S_OK        = 'ok';
		const S_UPLOADING = 'uploading';

		/**
		 * @return \yii\db\ActiveQuery
		 */
		public function getLogs ()
		{
			return $this->hasMany(Log::className(), [ 'fileGuid' => 'guid' ]);
		}

		/**
		 * @inheritdoc
		 */
		public function attributeLabels ()
		{
			return [
				'guid'      => Yii::tr('GUID'),
				'path'      => Yii::tr('Path'),
				'extension' => Yii::tr('Extension'),
				'name'      => Yii::tr('Name'),
				'size'      => Yii::tr('Size'),
				'status'    => Yii::tr('Status'),
				'message'   => Yii::tr('Message'),
				'dt'        => Yii::tr('DT'),
				'userID'    => Yii::tr('User ID'),
			];
		}

		/**
		 * @inheritdoc
		 */
		public function beforeSave ($insert)
		{
			if (parent::beforeSave($insert))
			{
				$this->dt = TimeHelper::now();

				return true;
			}

			return false;
		}

		/**
		 * @inheritdoc
		 */
		public function rules ()
		{
			return [
				[ [ 'dt' ], 'date', 'format' => 'y-MM-dd HH:mm:ss' ],
				[ [ 'extension', 'guid', 'message', 'name', 'path' ], 'trim' ],
				[ [ 'extension' ], 'string', 'max' => 10 ],
				[ [ 'size' ], 'string', 'max' => 20 ],
				[ [ 'guid' ], 'unique' ],
				[ [ 'guid' ], 'required' ],
				[ [ 'guid' ], 'string', 'length' => [ 1, 100 ] ],
				[ [ 'message' ], 'string' ],
				[ [ 'name', 'path' ], 'string', 'max' => 100 ],
				[ [ 'status' ], 'default', 'value' => self::S_NEW ],
				[ [ 'status' ], 'in', 'range' => [ self::S_DELETED, self::S_ERROR, self::S_NEW, self::S_OK, self::S_UPLOADING ] ],
				[ [ 'userID' ], 'integer' ]
			];
		}

		/**
		 * @inheritdoc
		 */
		public static function tableName ()
		{
			return 'vu_file';
		}
	}