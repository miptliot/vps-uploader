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
* fileGuid - Relation to file guid.
* status - Last status changed.
* message
* dt - Datetime when status was changed.
* userID - User by which status was changed.

# Config

**chunksize** - File chunk size in bytes to upload large files. Default is 1048576 (1M).
**extensions** - Allowed extensions to load. If _null_ then any extension is allowed.
**maxsize** - Maximum file size to upload. Default is _null_ (unlimited). Format is like 128M.
**path** - Base path to store files. Must be writable. 
**url** - Relative URL to build link for file. The full URL look like http(s)://<host><url>/<relative_path_to_file>.

# Requirements
You should include [Flow.js](https://github.com/flowjs/flow.js) library and CSS and JS file from [Jasny Bootstrap](https://github.com/jasny/bootstrap/).

If you want to see clipboard button to copy file links to clipboard you shoul include [clipboard.js](https://github.com/zenorocha/clipboard.js/).