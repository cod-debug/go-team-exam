import axios from 'axios';

const api_base_url = 'https://pokeapi.co/api/v2/';

export default { 
    login: async (payload) => {
        let res = {};
        try {
            res = await axios({
            method: "post",
            url: `/api/auth/login`,
            data: payload,
            headers: {
                "Content-Type": "application/json; charset=utf-8"
            },
        });
        } catch (e) {
            console.log(e);
            res.data = e?.response?.data || null
            res.status = e?.response?.status || null
        }
        return res;
    },

    register: async (payload) => {
        let res = {};
        try {
            res = await axios({
            method: "post",
            url: `/api/auth/register`,
            data: payload,
            headers: {
                "Content-Type": "application/json; charset=utf-8"
            },
        });
        } catch (e) {
            console.log(e);
            res.data = e?.response?.data || null
            res.status = e?.response?.status || null
        }
        return res;
    },
    getPokemon: async (payload) => {
        let res = {};
        try {
            res = await axios({
            method: "get",
            url: `${api_base_url}pokemon?limit=${payload.limit}&offset=${payload.offset}`,
            headers: {
                "Content-Type": "application/json; charset=utf-8"
            },
        });
        } catch (e) {
            console.log(e);
            res.data = e?.response?.data || null
            res.status = e?.response?.status || null
        }
        return res;
    },
    call: async (url) => {
        let res = {};
        try {
            res = await axios({
            method: "get",
            url: url,
            headers: {
                "Content-Type": "application/json; charset=utf-8"
            },
        });
        } catch (e) {
            console.log(e);
            res.data = e?.response?.data || null
            res.status = e?.response?.status || null
        }
        return res;
    },

    likePokemon: async (payload) => {
        let res = {};
        try {
            res = await axios({
            method: "post",
            url: `/api/users/like-pokemon`,
            data: payload,
            headers: {
                "Content-Type": "application/json; charset=utf-8"
            },
        });
        } catch (e) {
            console.log(e);
            res.data = e?.response?.data || null
            res.status = e?.response?.status || null
        }
        return res;
    },

    dislikePokemon: async (payload) => {
        let res = {};
        try {
            res = await axios({
            method: "post",
            url: `/api/users/dislike-pokemon`,
            data: payload,
            headers: {
                "Content-Type": "application/json; charset=utf-8"
            },
        });
        } catch (e) {
            console.log(e);
            res.data = e?.response?.data || null
            res.status = e?.response?.status || null
        }
        return res;
    },

    userList: async (payload) => {
        let res = {};
        try {
            res = await axios({
            method: "get",
            url: `/api/users/list`,
            params: payload,
            headers: {
                "Content-Type": "application/json; charset=utf-8"
            },
        });
        } catch (e) {
            console.log(e);
            res.data = e?.response?.data || null
            res.status = e?.response?.status || null
        }
        return res;
    },

    updateProfile: async (payload) => {
        let res = {};
        try {
            res = await axios({
            method: "post",
            url: `/api/users/update-profile`,
            params: payload,
            headers: {
                "Content-Type": "application/json; charset=utf-8"
            },
        });
        } catch (e) {
            console.log(e);
            res.data = e?.response?.data || null
            res.status = e?.response?.status || null
        }
        return res;
    }
}