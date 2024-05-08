export const handleFormError = (error, formErrorMessage) => {

    console.log(error);

    formErrorMessage.value = {}
    if(error.response.status == 422){
        Object.keys(error.response.data.errors).forEach(key => {
            formErrorMessage.value[key] = error.response.data.errors[key][0]
        })
    }else{
        formErrorMessage.value.message = error.response.data.message
    }
}

export const setupDataDropbox = (data, root, keyName = 'id') => {
    if (data !== undefined && Object.keys(data).length === 0 && data.constructor === Object) {
        return []
    }
    const options = [
        {
            value: 0,
            label: root
        },
        ...data.map(item => ({
            label: item.name,
            value: item[keyName]
        }))
    ]

    return options
}


export const resizeImage = (image, w, h) => {
    const ext = image.split('.').pop().toLowerCase();
    let queryString = ''
    if(w !== undefined){
        queryString += `&w=${w}`
    }

    if(h !== undefined){
        queryString += `&h=${h}`
    }
    const newImage = image.replace(/\.\w+$/, `.${ext}`);
    const modifiedImage = newImage.replace(`.${ext}`, '') + `?extension=${ext}` + queryString;
    return modifiedImage

}
