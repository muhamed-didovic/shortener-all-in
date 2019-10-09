import * as api from '../api'
// import axios from "axios";

export const shortenUrl = ({commit, dispatch, state}) => {
    commit('setShortened', null)
    commit('setWaiting', true)

    api
        .post({url: state.url})
        .then((response) => {
            commit('setShortened', response.data.data)
            commit('setUrl', null)
            commit('setWaiting', false)
        })
        .catch((error) => {
            if (error.response.status === 422) {
                dispatch('setMessage', error.response.data.errors.url[0], {root: true})
            }

            commit('setWaiting', false)
        })
}
