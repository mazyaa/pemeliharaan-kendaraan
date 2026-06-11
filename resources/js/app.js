import Alpine from 'alpinejs';
import Swal from 'sweetalert2';

window.Alpine = Alpine;
window.Swal = Swal;

// Global toast config
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    },
});
window.Toast = Toast;

// Auto-show flash messages — module scripts are deferred, DOM is ready
const flashSuccess = document.getElementById('flash-success');
const flashError = document.getElementById('flash-error');
const flashValidation = document.getElementById('flash-validation');
if (flashSuccess && flashSuccess.value) {
    Toast.fire({ icon: 'success', title: flashSuccess.value });
}
if (flashError && flashError.value) {
    Toast.fire({ icon: 'error', title: flashError.value });
}
if (flashValidation && flashValidation.value) {
    Toast.fire({ icon: 'error', title: flashValidation.value });
}

Alpine.start();
