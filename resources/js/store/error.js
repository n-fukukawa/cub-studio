const state = {
    errorCode: null,
    errorMessages: null,
}

const getters = {
    preErrorMessages: state => {
        if(state.errorMessages){
            let errMsgs = []
            Object.keys(state.errorMessages).forEach(key => {
                errMsgs.push(state.errorMessages[key][0])
            })
            return errMsgs
        }
        return null
    }
}

const mutations = {
    setErrorCode(state, errorCode) {
        state.errorCode = errorCode
    },
    setErrorMessages(state, errorMessages) {
        state.errorMessages = errorMessages;
    }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
}