function registerManager() {
        return {
            regName: '',
            regEmail: '',
            regPassword: '',
            regPasswordConfirmation: '',
            regShowPassword: false,
            regConfirmShowPassword: false,
            agreeTerms: false,
            loading: false,
            errorMessage: '',
            successMessage: '',
            passwordStrength: {
                text: '',
                class: '',
                width: 0
            },
            
            checkPasswordStrength() {
                const password = this.regPassword;
                let strength = 0;
                
                if (password.length >= 6) strength++;
                if (password.length >= 8) strength++;
                if (/[A-Z]/.test(password)) strength++;
                if (/[0-9]/.test(password)) strength++;
                if (/[^A-Za-z0-9]/.test(password)) strength++;
                
                if (password.length === 0) {
                    this.passwordStrength = { text: '', class: '', width: 0 };
                } else if (strength <= 1) {
                    this.passwordStrength = { text: 'Password lemah', class: 'weak', width: 25 };
                } else if (strength <= 2) {
                    this.passwordStrength = { text: 'Password sedang', class: 'medium', width: 50 };
                } else if (strength <= 3) {
                    this.passwordStrength = { text: 'Password kuat', class: 'strong', width: 75 };
                } else {
                    this.passwordStrength = { text: 'Password sangat kuat', class: 'very-strong', width: 100 };
                }
            },
            
            validateEmail(email) {
                const re = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
                return re.test(email);
            },
            
            submitRegister() {
                // Validation
                if (!this.regName.trim()) {
                    this.errorMessage = 'Nama lengkap harus diisi';
                    return;
                }
                if (!this.regEmail || !this.validateEmail(this.regEmail)) {
                    this.errorMessage = 'Email tidak valid';
                    return;
                }
                if (!this.regPassword || this.regPassword.length < 6) {
                    this.errorMessage = 'Password minimal 6 karakter';
                    return;
                }
                if (this.regPassword !== this.regPasswordConfirmation) {
                    this.errorMessage = 'Konfirmasi password tidak cocok';
                    return;
                }
                if (!this.agreeTerms) {
                    this.errorMessage = 'Anda harus menyetujui Syarat & Ketentuan';
                    return;
                }
                
                this.loading = true;
                this.errorMessage = '';
                
                // Simulasi registrasi - akan redirect ke halaman login
                setTimeout(() => {
                    this.successMessage = 'Registrasi berhasil! Silakan login dengan akun Anda.';
                    setTimeout(() => {
                        // Redirect ke halaman login admin
                        window.location.href = '{{ route("admin.login") }}?registered=success';
                    }, 1500);
                    this.loading = false;
                }, 1000);
            }
        }
    }