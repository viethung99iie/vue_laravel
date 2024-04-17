    <script setup>
        import axios from '@/config/axios';
        import { ref } from 'vue';
        import { useRouter } from 'vue-router'; // Change to useRouter
        import csrf from '@/config/csrf';
        import { useStore } from 'vuex';
        import { handleFormError } from '@/helpers/helpers';

        const email = ref('viethungw@gmail.com');
        const password = ref('password');
        const formErrorMessage = ref({});

        const router = useRouter(); // Change to useRouter

        const store = useStore(); // Change to useStore

        const handleLogin = async () => {
            try {
                await csrf.getCookie()
                await store.dispatch('auth/login',{email: email.value,password: password.value})
                await store.dispatch('message/showMessage',{
                    message : 'Đăng nhập vào hệ thành công!',
                    type : 'success'
                });
                router.push({ name: 'dashboard.index' }); // Use router.push for navigation
            } catch (error) {
                handleFormError(error,formErrorMessage);
            }
        }
    </script>

    <template>
        <div class="login-container">
            <form @submit.prevent="handleLogin()">
                <div class="login-wrapper">
                    <div class="panel-head">
                        <h2 class="heading-1 mb10">Đăng nhập</h2>
                        <div class="description">Chào mừng bạn đến với hệ thống <br> <span>VUE SYSTEM</span> </div>
                    </div>
                    <div class="panel-body">
                        <div v-if="formErrorMessage.message" class="uk-text-danger">*{{ formErrorMessage.message }}</div>
                        <div class="form-row mb-20">
                            <div class="label">Tên đăng nhập</div>
                            <input
                                type="text"
                                v-model="email"
                                class="input-text"
                                autocomplete="off"
                            >
                            <div v-if="formErrorMessage.email" class="uk-text-danger">*{{ formErrorMessage.email }}</div>
                        </div>
                        <div class="form-row mb-20">
                            <div class="label">
                                <div class="uk-flex uk-flex-between">
                                    <span>Mật khẩu</span>
                                    <router-link to="/dashboard" class="forgot">Quên mật khẩu?</router-link>
                                </div>
                            </div>
                            <input
                                type="password"
                                v-model="password"
                                class="input-text"
                                autocomplete="off"
                            >
                            <div v-if="formErrorMessage.password" class="uk-text-danger"> * {{ formErrorMessage.password }}</div>
                        </div>
                        <div class="form-row mb-20">
                            <button class="uk-button btn-login">Đăng nhập</button>
                        </div>
                    </div>
                    <div class="panel-foot">
                        copyright _viethungw@gmail.com
                    </div>
                </div>
            </form>
        </div>
    </template>

    <style scoped>
        .login-container{
            padding-top:100px
        }
        .login-wrapper{
            width: 410px;
            margin:0 auto;
            border-radius: 10px;
            box-shadow: 0 0.125rem 0 rgba(10,10,10,.04);
            padding:48px;
            background: #fff;
        }
        .login-container .panel-head{
            text-align: center;
            margin-bottom:30px;
        }
        .login-wrapper .heading-1{
            font-weight: 700;
            text-transform: uppercase;
            font-size:24px;
        }
        .login-container .description{
            font-size:15px;
            color:#000;
        }
        .login-container .description span{
            font-weight: bold;
            font-size:18px;
            text-transform: uppercase;
            color:rgb(132,90,223)
        }
        .btn-login{
            background: rgb(132,90,223);
            width:100%;
            border-radius: 5px;
            height:40px;
            color:#fff;
        }
        .login-wrapper .panel-foot{
            text-align: center;
        }
        .login-wrapper .label{
            font-weight: 600;
            margin-bottom:5px;
            color:#000;
        }

        .form-row .forgot{
            color: rgb(230,83,60);
            font-size:13px;
        }

    </style>
