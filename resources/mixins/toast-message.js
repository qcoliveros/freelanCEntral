export default {
    methods: {
        showSuccessMessage(message) {
            this.$swal({
                position: 'top-end',
                icon: 'success',
                text: message,
                showConfirmButton: false,
                timer: 1000,
                width: 400,
            })
        },

        showErrorMessage(message) {
            this.$swal({
                position: 'top-end',
                icon: 'error',
                text: message,
                showConfirmButton: false,
                timer: 1000,
                width: 400,
            })
        },
    },
};
