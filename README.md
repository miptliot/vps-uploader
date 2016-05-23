# About
This is file uploader developed specially for CIET MIPT projects. You can use it at your own risk!

# Table structure
## vu_file
* guid - Unique identificator for the file. Also works as filename. Generates randomly.
* path - Path to the file relative to the base datapath directory.
* extension
* name - Original filename.
* status - File status: new, uploading, error, deleted, ok.
* message - Message regarding status. Useful for errors.
* dt - Last file edit dt.
* userID - If you want to relate some user table for this file, use this field.

## vu_log
* guid - Relation to file guid.
* status - Last status changed.
* message
* dt - Datetime when status was changed.
* userID - User by which status was changed.

# Functionality