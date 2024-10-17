import axios from 'axios'
import { defineStore } from 'pinia'
import { handleError } from '@/scripts/helpers/error-handling'
import { useNotificationStore } from '@/scripts/stores/notification'

export const useTemplateStore = (useWindow = false) => {
  const defineStoreFunc = useWindow ? window.pinia.defineStore : defineStore
  const { global } = window.i18n

  return defineStoreFunc({
    id: 'templates',

    state: () => ({
      currentTemplate: {},
      templates: [],
      apiToken: null,
      currentUser: {
        api_token: null,
      },
    }),

    getters: {
      templates: (state) => state.templates,
    },

    actions: {
      fetchTemplates(params) {
        return new Promise((resolve, reject) => {
          axios
            .get(`/api/v1/templates`)
            .then((response) => {
              this.templates = response.data.data

              resolve(response)
            })
            .catch((err) => {
              handleError(err)
              reject(err)
            })
        })
      },

      fetchTemplate(id) {
        return new Promise((resolve, reject) => {
          axios
            .get(`/api/v1/templates/${id}`)
            .then((response) => {
              if (response.data.error === 'invalid_token') {
                this.currentTemplate = {},
                this.templates = [],
                this.apiToken = null,
                this.currentUser.api_token = null,
                window.router.push('/admin/templates')
              } else { 
                this.currentTemplate = response.data
              }

              resolve(response)
            })
            .catch((err) => {
              handleError(err)
              reject(err)
            })
        })
      },

      checkApiToken(token) {
        return new Promise((resolve, reject) => {
          axios
            .get(`/api/v1/templates/check?api_token=${token}`)
            .then((response) => {
              const notificationStore = useNotificationStore()
              if (response.data.error === 'invalid_token') {
                notificationStore.showNotification({
                  type: 'error',
                  message: global.t('modules.invalid_api_token'),
                })
              }
              resolve(response)
            })
            .catch((err) => {
              handleError(err)
              reject(err)
            })
        })
      },

      disableTemplate(template) {
        return new Promise((resolve, reject) => {
          axios
            .post(`/api/v1/templates/${template}/disable`)
            .then((response) => {
              const notificationStore = useNotificationStore()
              if (response.data.success) {
                notificationStore.showNotification({
                  type: 'success',
                  message: global.t('templates.template_disabled'),
                })
              }
              resolve(response)
            })
            .catch((err) => {
              handleError(err)
              reject(err)
            })
        })
      },

      enableTemplate(template) {
        return new Promise((resolve, reject) => {
          axios
            .post(`/api/v1/templates/${template}/enable`)
            .then((response) => {
              const notificationStore = useNotificationStore()
              if (response.data.success) {
                notificationStore.showNotification({
                  type: 'success',
                  message: global.t('templates.template_enabled'),
                })
              }
              resolve(response)
            })
            .catch((err) => {
              handleError(err)
              reject(err)
            })
        })
      },
    },
  })()
}
