<?php
	use \vps\tools\db\Migration;

	class m160523_164115_file_log extends Migration
	{
		public function safeUp ()
		{
			$tableOptions = null;
			if ($this->db->driverName === 'mysql')
			{
				// @see http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
				$tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
			}

			$this->createTable('vu_file', [
				'guid'      => $this->string(25)->notNull(),
				'path'      => $this->string(100),
				'extension' => $this->string(10),
				'size'      => $this->string(20),
				'name'      => $this->string(100),
				'status'    => 'enum("new", "uploading", "error", "deleted", "ok")  NOT NULL DEFAULT "new"',
				'message'   => $this->text(),
				'dt'        => $this->dateTime(),
				'userID'    => $this->integer()
			], $tableOptions);

			$this->addPrimaryKey('GUID', 'vu_file', 'guid');

			$this->createTable('vu_log', [
				'fileGuid' => $this->string(25)->notNull(),
				'status'   => 'enum("new", "uploading", "error", "deleted", "ok")  NOT NULL DEFAULT "new"',
				'message'  => $this->text(),
				'dt'       => $this->dateTime(),
				'userID'   => $this->integer()
			], $tableOptions);

			$this->addForeignKey('vu_log_file', 'vu_log', 'fileGuid', 'vu_file', 'guid', null, 'CASCADE');
		}

		public function safeDown ()
		{
			$this->dropForeignKey('vu_log_file', 'vu_log');
			$this->dropTable('vu_log');
			$this->dropTable('vu_file');
		}
	}
