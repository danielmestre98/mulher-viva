function prepareMultipartFormData(inputs) {
    const formData = new FormData();

    inputs.forEach((input) => {
        if (input.type === "file") {
            // If input is a file input, append each file to FormData
            const files = input.files;
            if (files.length > 0) {
                for (let i = 0; i < files.length; i++) {
                    formData.append(input.name, files[i]);
                }
            }
        } else if (input.type === "radio" || input.type === "checkbox") {
            // If input is a radio or checkbox and it's checked, append its value to FormData
            if (input.checked) {
                formData.append(input.name, input.value);
            }
        } else {
            // For other input types (text, textarea, etc.), append their values to FormData
            formData.append(input.name, input.value);
        }
    });

    // Convert FormData to JSON object
    const jsonObject = {};
    formData.forEach((value, key) => {
        // Check if the key already exists in the jsonObject
        if (Object.prototype.hasOwnProperty.call(jsonObject, key)) {
            // If key already exists, convert the value to an array
            if (!Array.isArray(jsonObject[key])) {
                jsonObject[key] = [jsonObject[key]];
            }
            jsonObject[key].push(value);
        } else {
            // If key does not exist, add it to the jsonObject
            jsonObject[key] = value;
        }
    });

    // Return the JSON object representing the form data
    return jsonObject;
}

export default prepareMultipartFormData;
