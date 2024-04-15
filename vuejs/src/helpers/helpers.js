 export const  handleFormError = (error,formErrorMessage) => {
    console.log(error);
    if(error.response.status == 422){
        formErrorMessage.value = {}
        Object.keys(error.response.data.errors).forEach(key => {
            formErrorMessage.value[key] = error.response.data.errors[key][0]
        })
    }else{
        formErrorMessage.value.message = error.response.data.message
    }
};

