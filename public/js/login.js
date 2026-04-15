function loginManager() {
        return {
            loginEmail: '',
            loginPassword: '',
            rememberMe: false,
            showPassword: false,
            loading: false,
            errorMessage: '',
            successMessage: '',
            
            init() {
                // Check if redirected from register
                const urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('registered') === 'success') {
                    this.successMessage = 'Registrasi berhasil! Silakan login dengan akun baru Anda.';
                    setTimeout(() => {
                        this.successMessage = '';
                    }, 5000);
                }
            },
            
            validateEmail(email) {
                const re = /^[^\s@]+@([^\s@]+\.)+[^\s@]+$/;
                return re.test(email);
            },
            
            async submitLogin() {
                if (!this.loginEmail || !this.loginPassword) {
                    this.errorMessage = 'Email dan password harus diisi';
                    return;
                }
                if (!this.validateEmail(this.loginEmail)) {
                    this.errorMessage = 'Format email tidak valid';
                    return;
                }
                
                this.loading = true;
                this.errorMessage = '';
                
                // Simulasi login
                setTimeout(() => {
                    if (this.loginEmail === 'admin@kopitiam33.id' && this.loginPassword === 'password') {
                        this.successMessage = 'Login berhasil! Mengalihkan ke dashboard...';
                        setTimeout(() => {
                            window.location.href = '/admin/dashboard';
                        }, 800);
                    } else {
                        this.errorMessage = 'Login gagal. Periksa email dan password Anda. (Demo: admin@kopitiam33.id / password)';
                    }
                    this.loading = false;
                }, 1000);
            }
        }
    }