export const passwordToggle = function() {
    this.children[0]?.classList.toggle('fa-eye');
    const password = document.getElementById(this.getAttribute('ct-target'));
    password.type = (password.type === 'password') ? 'text' : 'password';
}