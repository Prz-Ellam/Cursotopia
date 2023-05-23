export const mainService = async(method, url, contentType, data) => {
    try {
        const configuration = {
            method: method,
            url: url,
            headers: { 
                'Content-Type': contentType
            },
            data : data
        };
        const response = await axios(configuration);
        return response.data;
    }
    catch (exception) {
        if (exception.response)
            return exception.response.data;
        else
            throw exception
    }
}