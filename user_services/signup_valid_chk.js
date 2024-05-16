const regObj = {
    id : '^[a-z0-9]{6,14}$',
    pw : '^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{6,15}$',
    name : '^[a-zA-Z0-9]{2,14}$',
    email : '^[a-zA-Z0-9+-\_.]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$',
};

function isInputValid(k) {
    return () => {
        let allInputValid = true;

        let fieldId = fieldArray[k];
        let userInput = document.getElementById(fieldId);
        let fieldValid = document.getElementById(fieldId + '_valid');
        let regExp = new RegExp(regObj[fieldId]);

        if (!regExp.test(userInput.value)) {
            userInput.style.border = '1px solid #ff0000';
            fieldValid.style.display = 'block';
            allInputValid = false;
        } else {
            userInput.style.border = '1px solid #121481';
            fieldValid.style.display = 'none';
        }
        return allInputValid;
    };
}

function isBirthValid(k) {
    return () => {
        let birthValid = true;

        let fieldId = document.getElementById(birthArray[k]);
        let fieldValid = document.getElementById('birth_valid');

        if(fieldId.value.toLowerCase() === birthArray[k]) {
            fieldId.style.border = '1px solid #ff0000';
            fieldValid.style.display = 'block';
            birthValid = false;
        } else {
            fieldId.style.border = '1px solid #121481';
            fieldValid.style.display = 'none';
        }
        return birthValid;
    };
}