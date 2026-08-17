import {
    ClassicEditor,
    Essentials,
    Paragraph,
    Heading,
    Bold,
    Italic,
    Underline,
    Link,
    List,
    BlockQuote,
    Alignment,
    Undo,
    Font,
    Table,
    TableToolbar,
    Image,
    ImageUpload,
    ImageToolbar,
    ImageCaption,
    ImageStyle,
    ImageTextAlternative,
    LinkImage,
} from "ckeditor5";

import "ckeditor5/ckeditor5.css";

/*
|--------------------------------------------------------------------------
| Custom Upload Adapter
|--------------------------------------------------------------------------
*/

class BlogImageUploadAdapter {
    constructor(loader, uploadUrl, csrfToken) {
        this.loader = loader;

        this.uploadUrl = uploadUrl;

        this.csrfToken = csrfToken;

        this.xhr = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Upload
    |--------------------------------------------------------------------------
    */

    upload() {
        return this.loader.file.then((file) => {
            return new Promise((resolve, reject) => {
                this._initializeRequest();

                this._initializeListeners(resolve, reject, file);

                this._sendRequest(file);
            });
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Abort
    |--------------------------------------------------------------------------
    */

    abort() {
        if (this.xhr) {
            this.xhr.abort();
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Initialize Request
    |--------------------------------------------------------------------------
    */

    _initializeRequest() {
        const xhr = (this.xhr = new XMLHttpRequest());

        xhr.open("POST", this.uploadUrl, true);

        xhr.responseType = "json";

        /*
        |--------------------------------------------------------------------------
        | Headers
        |--------------------------------------------------------------------------
        */

        xhr.setRequestHeader("Accept", "application/json");

        if (this.csrfToken) {
            xhr.setRequestHeader("X-CSRF-TOKEN", this.csrfToken);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Initialize Listeners
    |--------------------------------------------------------------------------
    */

    _initializeListeners(resolve, reject, file) {
        const xhr = this.xhr;

        const loader = this.loader;

        const genericErrorText = `Couldn't upload file: ${file.name}.`;

        /*
        |--------------------------------------------------------------------------
        | Error
        |--------------------------------------------------------------------------
        */

        xhr.addEventListener("error", () => {
            reject(genericErrorText);
        });

        /*
        |--------------------------------------------------------------------------
        | Abort
        |--------------------------------------------------------------------------
        */

        xhr.addEventListener("abort", () => {
            reject();
        });

        /*
        |--------------------------------------------------------------------------
        | Load
        |--------------------------------------------------------------------------
        */

        xhr.addEventListener("load", () => {
            const response = xhr.response;

            /*
                |--------------------------------------------------------------------------
                | Laravel Validation Errors
                |--------------------------------------------------------------------------
                */

            if (xhr.status === 422 && response && response.errors) {
                const firstError = Object.values(response.errors)[0];

                return reject(
                    Array.isArray(firstError)
                        ? firstError[0]
                        : genericErrorText,
                );
            }

            /*
                |--------------------------------------------------------------------------
                | Server Error
                |--------------------------------------------------------------------------
                */

            if (!response || xhr.status < 200 || xhr.status >= 300) {
                return reject(response?.error?.message || genericErrorText);
            }

            /*
                |--------------------------------------------------------------------------
                | CKEditor Expected URL
                |--------------------------------------------------------------------------
                */

            if (!response.url) {
                return reject("Server did not return an image URL.");
            }

            /*
                |--------------------------------------------------------------------------
                | Success
                |--------------------------------------------------------------------------
                |
                | CKEditor expects:
                |
                | {
                |     default: 'https://...'
                | }
                |
                */

            resolve({
                default: response.url,
            });
        });

        /*
        |--------------------------------------------------------------------------
        | Upload Progress
        |--------------------------------------------------------------------------
        */

        if (xhr.upload) {
            xhr.upload.addEventListener("progress", (event) => {
                if (event.lengthComputable) {
                    loader.uploadTotal = event.total;

                    loader.uploaded = event.loaded;
                }
            });
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Send File
    |--------------------------------------------------------------------------
    */

    _sendRequest(file) {
        const data = new FormData();

        /*
        |--------------------------------------------------------------------------
        | Important
        |--------------------------------------------------------------------------
        |
        | Laravel controller expects:
        |
        | $request->file('upload')
        |
        */

        data.append("upload", file);

        this.xhr.send(data);
    }
}

/*
|--------------------------------------------------------------------------
| Custom CKEditor Plugin
|--------------------------------------------------------------------------
*/

function BlogCustomUploadAdapterPlugin(editor) {
    /*
    |--------------------------------------------------------------------------
    | Upload URL
    |--------------------------------------------------------------------------
    */

    const uploadUrl = editor.sourceElement?.dataset?.uploadUrl;

    /*
    |--------------------------------------------------------------------------
    | CSRF Token
    |--------------------------------------------------------------------------
    */

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

    if (!uploadUrl) {
        console.error("CKEditor upload URL is missing.");

        return;
    }

    /*
    |--------------------------------------------------------------------------
    | Register Adapter
    |--------------------------------------------------------------------------
    */

    editor.plugins.get("FileRepository").createUploadAdapter = (loader) => {
        return new BlogImageUploadAdapter(loader, uploadUrl, csrfToken);
    };
}

/*
|--------------------------------------------------------------------------
| Editor Element
|--------------------------------------------------------------------------
*/

const editorElement = document.querySelector("#blog-content");

/*
|--------------------------------------------------------------------------
| Initialize CKEditor
|--------------------------------------------------------------------------
*/

if (editorElement) {
    ClassicEditor.create(editorElement, {
        /*
                |--------------------------------------------------------------------------
                | License
                |--------------------------------------------------------------------------
                */

        licenseKey: import.meta.env.VITE_CKEDITOR_LICENSE_KEY,

        /*
                |--------------------------------------------------------------------------
                | Plugins
                |--------------------------------------------------------------------------
                */

        plugins: [
            Essentials,
            Paragraph,
            Heading,

            Bold,
            Italic,
            Underline,

            Link,
            List,
            BlockQuote,
            Alignment,

            Undo,
            Font,

            Table,
            TableToolbar,

            Image,
            ImageUpload,
            ImageToolbar,
            ImageCaption,
            ImageStyle,
            ImageTextAlternative,
            LinkImage,
        ],

        /*
                |--------------------------------------------------------------------------
                | Custom Upload Plugin
                |--------------------------------------------------------------------------
                */

        extraPlugins: [BlogCustomUploadAdapterPlugin],

        /*
                |--------------------------------------------------------------------------
                | Main Toolbar
                |--------------------------------------------------------------------------
                */

        toolbar: {
            items: [
                "undo",
                "redo",

                "|",

                "heading",

                "|",

                "bold",
                "italic",
                "underline",

                "|",

                "fontSize",
                "fontFamily",

                "fontColor",
                "fontBackgroundColor",

                "|",

                "link",

                "bulletedList",
                "numberedList",

                "|",

                "alignment",

                "blockQuote",

                "|",

                /*
                        |--------------------------------------------------------------------------
                        | Image Upload Button
                        |--------------------------------------------------------------------------
                        */

                "uploadImage",

                "|",

                "insertTable",
            ],

            shouldNotGroupWhenFull: true,
        },

        /*
                |--------------------------------------------------------------------------
                | Image Settings
                |--------------------------------------------------------------------------
                */

        image: {
            toolbar: [
                "imageTextAlternative",

                "toggleImageCaption",

                "|",

                "imageStyle:inline",

                "imageStyle:block",

                "imageStyle:side",

                "|",

                "linkImage",
            ],
        },

        /*
                |--------------------------------------------------------------------------
                | Table
                |--------------------------------------------------------------------------
                */

        table: {
            contentToolbar: ["tableColumn", "tableRow", "mergeTableCells"],
        },

        /*
                |--------------------------------------------------------------------------
                | Placeholder
                |--------------------------------------------------------------------------
                */

        placeholder: "Write your blog content here...",
    })

        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        .then((editor) => {
            window.blogEditor = editor;

            console.log("Bagora CKEditor initialized.");
        })

        /*
        |--------------------------------------------------------------------------
        | Error
        |--------------------------------------------------------------------------
        */

        .catch((error) => {
            console.error("CKEditor initialization error:", error);
        });
}
