window.addEventListener('toast:success', event => {
    toastr.success(event.detail.message)
})