<template>
    <LoadingComponent :props="loading" />
    <section class="login-section">
        <!-- Animated background elements -->
        <div class="bg-orb bg-orb-1"></div>
        <div class="bg-orb bg-orb-2"></div>
        
        <div class="container login-container">
            <div class="login-card">
                <!-- Top accent bar -->
                <div class="card-accent"></div>
                
                <h2 class="login-title">
                    {{ $t('label.welcome_back') }}
                </h2>
                
                <div v-if="errors.validation" class="error-alert" role="alert">
                    <span class="alert-text">{{ errors.validation }}</span>
                    <button type="button" @click="close" class="alert-close">
                        <i class="lab lab-close-circle-line"></i>
                    </button>
                </div>
                
                <form @submit.prevent="login" class="login-form">
                    <div class="form-group">
                        <label for="formEmail" class="form-label">
                            {{ $t('label.email') }}
                        </label>
                        <input 
                            type="email" 
                            :class="['form-input', { 'input-invalid': errors.email }]" 
                            v-model="form.email"
                            id="formEmail"
                            placeholder="your@email.com"
                        >
                        <small class="field-error" v-if="errors.email">{{ errors.email[0] }}</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="formPassword" class="form-label">
                            {{ $t('label.password') }}
                        </label>
                        <input 
                            autocomplete="off" 
                            type="password" 
                            :class="['form-input', { 'input-invalid': errors.password }]"
                            v-model="form.password"
                            id="formPassword"
                            placeholder="••••••••"
                        >
                        <small class="field-error" v-if="errors.password">{{ errors.password[0] }}</small>
                    </div>
                    
                    <div class="form-footer">
                        <div class="checkbox-group">
                            <label class="custom-checkbox">
                                <input type="checkbox" id="checkbox2">
                                <span class="checkmark"></span>
                                <span class="checkbox-label">{{ $t('label.remember_me') }}</span>
                            </label>
                        </div>
                        <router-link 
                            :to="{ name: 'auth.forgetPassword' }"
                            class="forgot-link"
                        >
                            {{ $t('button.forget_password') }}
                        </router-link>
                    </div>
                    
                    <button type="submit" class="btn-login">
                        <span class="btn-text">{{ $t('button.login') }}</span>
                    </button>
                </form>
            </div>

            <div 
                v-if="demo === 'true' || demo === 'TRUE' || demo === 'True' || demo === '1' || demo === 1"
                class="demo-card"
            >
                <h3 class="demo-title">{{ $t('message.for_quick_demo') }}</h3>
                <nav class="demo-grid">
                    <button 
                        @click.prevent="setupCredit('admin')"
                        class="demo-btn demo-admin"
                        id="adminClick"
                    >
                        <span class="btn-content">{{ $t('label.admin') }}</span>
                    </button>
                    <button 
                        @click.prevent="setupCredit('branchManager')"
                        class="demo-btn demo-manager"
                        id="branchManagerClick"
                    >
                        <span class="btn-content">{{ $t('label.branch_manager') }}</span>
                    </button>
                    <button 
                        @click.prevent="setupCredit('posOperator')"
                        class="demo-btn demo-operator"
                        id="posOperatorClick"
                    >
                        <span class="btn-content">{{ $t('label.pos_operator') }}</span>
                    </button>
                    <button 
                        @click.prevent="setupCredit('chef')"
                        class="demo-btn demo-chef"
                        id="chefClick"
                    >
                        <span class="btn-content">{{ $t('label.chef_kitchen') }}</span>
                    </button>
                </nav>
            </div>
        </div>
    </section>
</template>

<script>
import router from "../../../router";
import LoadingComponent from "../components/LoadingComponent";
import alertService from "../../../services/alertService";
import ENV from "../../../config/env";
import { routes } from "../../../router";
import appService from "../../../services/appService";

export default {
    name: "LoginComponent",
    components: { LoadingComponent },
    data() {
        return {
            loading: {
                isActive: false,
            },
            form: {
                email: "",
                password: ""
            },
            errors: {},
            permissions: {},
            firstMenu: null,
            demo: ENV.DEMO
        }
    },
    computed: {
        permission: function () {
            return this.$store.getters.authPermission;
        }
    },
    methods: {
        login: function () {
            try {
                this.loading.isActive = true;
                this.$store.dispatch('login', this.form).then((res) => {
                    this.loading.isActive = false;
                    alertService.success(res.data.message);
                    router.push({ name: "admin.dashboard" });

                    setTimeout(() => {
                        appService.recursiveRouter(routes, this.permission);
                    }, 300)

                }).catch((err) => {
                    this.loading.isActive = false;
                    this.errors = err.response.data.errors;
                })
            } catch (err) {
                this.loading.isActive = false;
            }
        },
        close: function () {
            this.errors = {}
        },
        setupCredit: function (e) {
            if (e === 'admin') {
                this.form.email = 'admin@example.com';
                this.form.password = '123456';
            } else if (e === 'customer') {
                this.form.email = 'customer@example.com';
                this.form.password = '123456';
            } else if (e === 'branchManager') {
                this.form.email = 'branchmanager@example.com';
                this.form.password = '123456';
            } else if (e === 'posOperator') {
                this.form.email = 'posoperator@example.com';
                this.form.password = '123456';
            } else if (e === 'chef') {
                this.form.email = 'chef@example.com';
                this.form.password = '123456';
            }
        }
    }
}
</script>

<style scoped>
@import url('https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&family=Instrument+Serif:ital@0;1&display=swap');

/* CSS Variables */
:root {
    --primary: #0F172A;
    --primary-light: #1E293B;
    --accent: #F97316;
    --accent-hover: #EA580C;
    --text: #334155;
    --text-light: #64748B;
    --border: #E2E8F0;
    --bg-light: #F8FAFC;
    --white: #FFFFFF;
    --error: #DC2626;
    --error-bg: #FEE2E2;
}

/* Section Styling */
.login-section {
    min-height: 100vh;
    background: linear-gradient(135deg, #0F172A 0%, #1E293B 50%, #334155 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
    position: relative;
    overflow: hidden;
}

/* Animated Background Orbs */
.bg-orb {
    position: absolute;
    border-radius: 50%;
    pointer-events: none;
}

.bg-orb-1 {
    top: -30%;
    right: -10%;
    width: 50%;
    height: 50%;
    background: radial-gradient(circle, rgba(249, 115, 22, 0.15) 0%, transparent 70%);
    animation: float 8s ease-in-out infinite;
}

.bg-orb-2 {
    bottom: -20%;
    left: -10%;
    width: 40%;
    height: 40%;
    background: radial-gradient(circle, rgba(249, 115, 22, 0.1) 0%, transparent 70%);
    animation: float 6s ease-in-out infinite reverse;
}

@keyframes float {
    0%, 100% {
        transform: scale(1) translateY(0);
        opacity: 1;
    }
    50% {
        transform: scale(1.1) translateY(-20px);
        opacity: 0.8;
    }
}

/* Container */
.login-container {
    max-width: 440px;
    width: 100%;
    position: relative;
    z-index: 1;
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Main Login Card */
.login-card {
    background: var(--white);
    border-radius: 24px;
    padding: 3rem 2.5rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3), 
                0 0 0 1px rgba(255, 255, 255, 0.1);
    margin-bottom: 1.5rem;
    position: relative;
    overflow: hidden;
}

.card-accent {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--accent) 0%, #FBBF24 100%);
}

/* Title */
.login-title {
    font-family: 'Syne', sans-serif;
    font-size: 2rem;
    font-weight: 700;
    text-align: center;
    margin-bottom: 2rem;
    color: var(--primary);
    letter-spacing: -0.02em;
    animation: fadeIn 0.8s 0.2s cubic-bezier(0.4, 0, 0.2, 1) backwards;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Error Alert */
.error-alert {
    background: var(--error-bg);
    border: 1px solid var(--error);
    border-radius: 12px;
    padding: 1rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    animation: slideDown 0.3s ease-out;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.alert-text {
    flex: 1;
    color: var(--error);
    font-size: 0.875rem;
    line-height: 1.5;
}

.alert-close {
    background: none;
    border: none;
    color: var(--error);
    cursor: pointer;
    font-size: 1.25rem;
    line-height: 1;
    padding: 0;
    transition: transform 0.2s;
}

.alert-close:hover {
    transform: scale(1.1);
}

/* Form Groups */
.login-form {
    animation: fadeIn 0.8s 0.3s cubic-bezier(0.4, 0, 0.2, 1) backwards;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    font-family: 'Syne', sans-serif;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text);
    margin-bottom: 0.5rem;
    text-transform: capitalize;
}

/* Form Inputs */
.form-input {
    width: 100%;
    height: 52px;
    padding: 0 1.25rem;
    font-family: 'Instrument Serif', serif;
    font-size: 1rem;
    color: var(--primary);
    background: var(--bg-light);
    border: 2px solid var(--border);
    border-radius: 12px;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.form-input:focus {
    outline: none;
    border-color: var(--accent);
    background: var(--white);
    box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
    transform: translateY(-2px);
}

.form-input::placeholder {
    color: var(--text-light);
    opacity: 0.5;
}

.input-invalid {
    border-color: var(--error);
    background: var(--error-bg);
}

.field-error {
    display: block;
    color: var(--error);
    font-size: 0.75rem;
    margin-top: 0.5rem;
    animation: slideDown 0.2s ease-out;
}

/* Form Footer */
.form-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 2rem;
}

/* Custom Checkbox */
.checkbox-group {
    display: flex;
    align-items: center;
}

.custom-checkbox {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    position: relative;
}

.custom-checkbox input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
    height: 0;
    width: 0;
}

.checkmark {
    position: relative;
    height: 18px;
    width: 18px;
    background-color: var(--white);
    border: 2px solid var(--border);
    border-radius: 4px;
    transition: all 0.2s;
}

.custom-checkbox:hover .checkmark {
    border-color: var(--accent);
}

.custom-checkbox input:checked ~ .checkmark {
    background-color: var(--accent);
    border-color: var(--accent);
}

.checkmark::after {
    content: "";
    position: absolute;
    display: none;
    left: 5px;
    top: 2px;
    width: 4px;
    height: 8px;
    border: solid white;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
}

.custom-checkbox input:checked ~ .checkmark::after {
    display: block;
}

.checkbox-label {
    font-family: 'Syne', sans-serif;
    font-size: 0.875rem;
    color: var(--text);
    user-select: none;
}

/* Forgot Password Link */
.forgot-link {
    font-family: 'Syne', sans-serif;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--accent);
    text-decoration: none;
    transition: all 0.2s;
}

.forgot-link:hover {
    color: var(--accent-hover);
    text-decoration: underline;
}

/* Login Button */
.btn-login {
    width: 100%;
    height: 52px;
    font-family: 'Syne', sans-serif;
    font-size: 1rem;
    font-weight: 600;
    color: var(--white);
    background: linear-gradient(135deg, var(--accent) 0%, var(--accent-hover) 100%);
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.btn-text {
    position: relative;
    z-index: 1;
}

.btn-login::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-login:hover::before {
    left: 100%;
}

.btn-login:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px rgba(249, 115, 22, 0.4);
}

.btn-login:active {
    transform: translateY(0);
}

/* Demo Card */
.demo-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 24px;
    padding: 2rem 2.5rem;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    animation: fadeInUp 0.8s 0.2s cubic-bezier(0.4, 0, 0.2, 1) backwards;
}

.demo-title {
    font-family: 'Syne', sans-serif;
    font-size: 1.25rem;
    font-weight: 600;
    text-align: center;
    margin-bottom: 1.5rem;
    color: var(--primary);
}

/* Demo Grid */
.demo-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 0.75rem;
}

/* Demo Buttons */
.demo-btn {
    height: 48px;
    font-family: 'Syne', sans-serif;
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--white);
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    text-transform: capitalize;
    position: relative;
    overflow: hidden;
}

.btn-content {
    position: relative;
    z-index: 1;
}

.demo-btn::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.demo-btn:hover::after {
    width: 300px;
    height: 300px;
}

.demo-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
}

.demo-btn:active {
    transform: translateY(-1px);
}

/* Demo Button Colors */
.demo-admin {
    background: linear-gradient(135deg, #F97316 0%, #EA580C 100%);
}

.demo-manager {
    background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%);
}

.demo-operator {
    background: linear-gradient(135deg, #A855F7 0%, #9333EA 100%);
}

.demo-chef {
    background: linear-gradient(135deg, #22C55E 0%, #16A34A 100%);
}

/* Responsive Design */
@media (max-width: 640px) {
    .login-card {
        padding: 2rem 1.5rem;
    }
    
    .demo-card {
        padding: 1.5rem;
    }
    
    .login-title {
        font-size: 1.75rem;
    }
    
    .form-footer {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
}
</style>