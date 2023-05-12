import axios from 'axios';

export default class CategoryService {
    static findAll = async () => {
        try {
            const configuration = {
                method: 'GET',
                url: `/api/v1/categories`,
                headers: {
                    'Content-Type': 'application/json'
                }
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data
        }
    }

    static findById = async (id) => {
        try {
            const configuration = {
                method: 'GET',
                url: `/api/v1/categories/${id}`,
                headers: {
                    'Content-Type': 'application/json'
                }
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data
        }
    }

    static findApproved = async () => {
        try {
            const configuration = {
                method: 'GET',
                url: `/api/v1/categories/approved`,
                headers: {
                    'Content-Type': 'application/json'
                }
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data
        }
    }

    static findnotApproved = async () => {
        try {
            const configuration = {
                method: 'GET',
                url: `/api/v1/categories/notApproved`,
                headers: {
                    'Content-Type': 'application/json'
                }
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data
        }
    }

    static findnotActive = async () => {
        try {
            const configuration = {
                method: 'GET',
                url: `/api/v1/categories/notActive`,
                headers: {
                    'Content-Type': 'application/json'
                }
            };
            const response = await axios(configuration);
            return response.data;
        }
        catch (exception) {
            return exception.response.data
        }
    }
}

export const createCategory = async (category) => {
    try {
        const configuration = {
            method: 'POST',
            url: `/api/v1/categories`,
            headers: {
                'Content-Type': 'application/json'
            },
            data : JSON.stringify(category)
        };
        const response = await axios(configuration);
        return response.data;
    }
    catch (exception) {
        return exception.response.data;
    }
}

export const approveCategoryService = async (categoryId) => {
    try {
        const configuration = {
            method: 'PUT',
            url: `/api/v1/categories/${categoryId}/approve`,
            headers: {
                'Content-Type': 'application/json'
            }
        };
        const response = await axios(configuration);
        return response.data;
    }
    catch (exception) {
        return exception.response.data
    }
}

export const updateCategoryService = async (id, category) => {
    try {
        const configuration = {
            method: 'PUT',
            url: `/api/v1/categories/${id}`,
            headers: {
                'Content-Type': 'application/json'
            },
            data : JSON.stringify(category)
        };
        const response = await axios(configuration);
        return response.data;
    }
    catch (exception) {
        return exception.response.data
    }
}

export const denyCategoryService = async (categoryId) => {
    try {
        const configuration = {
            method: 'PUT',
            url: `/api/v1/categories/${categoryId}/deny`,
            headers: {
                'Content-Type': 'application/json'
            }
        };
        const response = await axios(configuration);
        return response.data;
    }
    catch (exception) {
        return exception.response.data
    }
}

export const activateCategoryService = async (categoryId) => {
    try {
        const configuration = {
            method: 'PUT',
            url: `/api/v1/categories/${categoryId}/activate`,
            headers: {
                'Content-Type': 'application/json'
            }
        };
        const response = await axios(configuration);
        return response.data;
    }
    catch (exception) {
        return exception.response.data
    }
}

export const deactivateCategoryService = async (categoryId) => {
    try {
        const configuration = {
            method: 'PUT',
            url: `/api/v1/categories/${categoryId}/deactivate`,
            headers: {
                'Content-Type': 'application/json'
            }
        };
        const response = await axios(configuration);
        return response.data;
    }
    catch (exception) {
        return exception.response.data
    }
}

export const getAllCategories = async (category) => {
    
}