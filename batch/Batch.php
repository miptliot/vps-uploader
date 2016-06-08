<?php
	namespace vps\uploader\batch;

	use vps\uploader\models\File;
	use yii\base\Object;

	class Batch extends Object
	{
		/**
		 * Copy file name to GUIDs.
		 * @param string[] $guids
		 * @return BatchResult
		 */
		public static function guidFromName ($guids)
		{
			$result = new BatchResult();

			$files = File::find()->where([ 'guid' => $guids ])->all();
			foreach ($files as $file)
			{
				$guid = $file->guid;
				$file->guid = $file->name;
				if ($file->save())
					$result->ok($file->guid);
				else
					$result->error($guid);
			}

			return $result;
		}
	}