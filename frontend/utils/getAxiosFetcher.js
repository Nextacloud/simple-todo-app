const { axios } = require("./getAxios");


export const axiosFetcher = url => axios.get(url).then(res => res.data)