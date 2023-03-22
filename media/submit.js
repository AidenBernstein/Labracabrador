// noinspection JSJQueryEfficiency

/*helper function
$(str id): elementObj*/
/*const $ = (id) => {
    return document.getElementById(id);
};*/

//global variable for the file, so I can use an event listener
let file;
//global variable for the description character count, so I can use an event listener
let descFilled = false;

/*every time the file upload is changed, updates the 'file' global with whatever file the user uploads*/
$('media').addEventListener('change', (event) => {
    file = event.target.files[0];
});

/*every time a key is pressed, updates the 'descFilled' global w/ true or false depending on how many characters in the description and updates the css if the user goes over the character limit*/
$('desc').addEventListener('keydown', () => {
    let length = $('desc').value.length + 1;
    $('descErr').innerHTML = ` ${length} / 2000 characters`;
    if(length > 2000) {
        $('descErr').className = 'error';
        descFilled = true;
    } else {
        $('descErr').classList.remove('error');
        descFilled = false;
    }
});

/*validates file type using mime types.
validateType(str mime): boolean*/
const validateType = (mime) => {
    mime = mime.split('/');
    switch (mime[0]) {
        case 'application':
            switch(mime[1]){
                case 'x-7z-compressed':
                case 'epub+zip':
                case 'x-zip-compressed':
                case 'zip':
                case 'vnd.geogebra.file':
                case 'vnd.geogebra.tool':
                case 'x-gtar':
                case 'vnd.musician':
                    $('type').value = 'application';
                    return true;

                case 'x-font-ttf':
                    $('type').value = 'font';
                    return true;

                case 'msword':
                case 'vnd.ms-word.document.macroEnabled.12':
                case 'vnd.ms-word.template.macroEnabled.12':
                case 'vnd.openxmlformats-officedocument.wordprocessingml.document':
                case 'pdf':
                case 'rtf':
                case 'x-latex':
                    $('type').value = 'document';
                    return true;

                default:
                    return false;
            }
        case 'chemical':
        case 'message':
        case 'multipart':
        case 'example':
            return false;

        case 'text':
            switch(mime[1]){
                case 'css':
                case 'vnd.hal+html':
                case 'html':
                case 'javascript':
                case 'x-source,java':
                case 'ecmascript':
                    return false;
                default:
                    $('type').value = 'text';
                    return true;
            }

        case '':
        case 'Error: No file type':
            return false;

        default:
            $('type').value = mime[0];
            return true;
    }
};

/*uses validateMedia() to determine if the file type is acceptable, then checks if the file is <39MiB, then updates the error field
validateMedia(): boolean*/
const validateMedia = () => {
    console.log('validate media');
    let info = '';
    const valid = validateType(file.type);

    if(!valid){
        info += ` "${file.type}" is not an allowed file type. Please resubmit in a different format.<br />`;
    }
    console.log(valid);

    if(file.size > 39000000) {
        info += " File size too large. Please submit file under 39mb."
    }

    if(valid && !(file.size > 39000000)) {
        $('mediaErr').innerHTML = '';
        return true;
    }

    $('mediaErr').innerHTML = info;
    return false;
};

/*trims whitespace, checks that everything is filled, makes sure that username and key do not have spaces
checkFilled(): boolean*/
const checkFilled = () => {
    let valid = true;

    const user = $('username');
    const userErr = $('usernameErr');

    const key = $('key');
    const keyErr = $('keyErr');

    const title = $('title');
    const titleErr = $('titleErr');

    const desc = $('desc');
    const descErr = $('descErr');

    user.value = user.value.trim();
    key.value = key.value.trim();
    title.value = title.value.trim();
    desc.value = desc.value.trim();

    if(user.value === '') {
        userErr.innerHTML = ' * Username field required';
        valid = false;
    }

    if(user.value.indexOf(' ') >= 0){               //This works because the user and key values are trimmed before this, so there can never be a space in the first place of the string
        userErr.innerHTML = ' Username cannot contain spaces';
        valid = false;
    }

    if(key.value === '') {
        keyErr.innerHTML = ' * Key field required';
        valid = false;
    }

    if(key.value.indexOf(' ') >= 0){
        keyErr.innerHTML = ' Key cannot contain spaces';
        valid = false;
    }

    if(title.value === '') {
        titleErr.innerHTML = ' * Title field required';
        valid = false;
    }

    if(desc.value === '') {
        $('descErr').className = 'error';           //required because, otherwise, there are cases where this if statement runs, but the descErr <span> doesn't have the 'error' class
        descErr.innerHTML = ' * Description is a required field';
        valid = false;
    }

    if(descFilled) {
        descErr.innerHTML = ' Description must not be longer than 2000 characters';
        valid = false;
    }

    if(valid) {                                     //removes any error messages if everything is valid
        userErr.innerHTML = '';
        keyErr.innerHTML = '';
        titleErr.innerHTML = '';
        descErr.innerHTML = '';
    }

    return valid;
};

/*if file is null or file.type dne or is null, set file.type to an alert. Uses validateMedia() and checkFilled() to ensure validity and, if they return true, submit form.
Called by onClick in the button w/ id #Submit
pressSubmit(): void*/
const pressSubmit = () => {
    console.log('submit');
    if(!file || !file.type) {
        file = {size: 0, type: "Error: No file type"};
        console.log('no file');
    }

    // noinspection JSBitwiseOperatorUsage
    if(validateMedia() & checkFilled()) {           //single & so that JS runs both functions
        console.log('valid');
        console.log($('type').value);
        document.forms["submission"].requestSubmit();
    }
};