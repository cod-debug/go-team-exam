<template>
    <div>
        <div id="mainDiv" class="row items-center" :class="is_register ? 'reverse' : ''" style="transition: .3s all ease-in;">
          <div class="bg-orange-2 fixed" style="z-index: -1; width: 80%; height: 200%; rotate: 15deg; left: -30%;"></div>
          <div class="full-height flex column justify-center col-md-6 col-sm-4">
            <img src="/assets/images/banner.png" style="width: 80%; margin: auto;" />
          </div>
          <div class="flex items-center q-pa-lg full-height col-md-6 col-sm-8">
            <q-form class="full-width q-pa-xl" @submit.prevent="submitLogin" ref="form" greedy v-if="!is_register">
              <div class="text-center q-pa-lg" style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
                <img src="/assets/images/logo.png" alt="pokeball" style="width: 300px;" />
                <div class=" text-orange-6 text-h4">Let's checkout some Pokemon!</div>
              </div>
              <div class="full-width">
                <q-input rounded outlined v-model="username" label="Username" :rules="[
                      val => val && val.length > 0 || 'Username is required',
                    ]"/>
              </div>
              <div class="full-width q-py-sm">
                <q-input rounded outlined v-model="password" label="Password" :type="show_password ? 'text': 'password'" :rules="[
                  val => val && val.length > 0 || 'Password is required',
                ]">
                  <template v-slot:append>
                    <q-btn round dense flat :icon="show_password ? 'visibility' : 'visibility_off'" @click="show_password = !show_password" />
                  </template>
                </q-input>
              </div>
              <div class="full-width q-py-sm flex items-center justify-between q-pl-sm">
                <div class="text-h6 text-grey-6">Sign in</div>
                <q-btn type="submit" style="aspect-ratio: 1/1; border-radius: 50%;" icon="arrow_forward" color="red-8" glossy />
              </div>
              <div class="text-center">
                <span class="text-grey-7">Don't have an account yet? <span @click="openRegister" class="text-orange-8 cursor-pointer">Sign up</span></span>
              </div>
            </q-form>
            <app-register-user @openLogin="openLogin" v-else />
          </div>
        </div>
    </div>
  </template>
  
  <script>
  import { Notify } from 'quasar';  
  import RegisterUser from '../components/Register.vue';
  import axios from 'axios';
  export default {
    data: () => {
      return {
        username:"",
        password: "",
        show_password: false,

        is_register: false,
      }
    },
    methods: {
      async submitLogin(){
        let valid = await this.$refs.form.validate();
        if(!valid){
          return false;
        }

        let payload = {
          email: this.username,
          password: this.password
        }
        let {data, status} = await axios({
          method: "post",
          url: `/api/auth/login`,
          data: payload,
          headers: {
              "Content-Type": "application/json; charset=utf-8"
          },
        });
      },

      openRegister(){
        this.is_register = true;
      },
      openLogin(){
        this.is_register = false;       
      }
    },
    components: {
      AppRegisterUser: RegisterUser,
    }
  }
  </script>
  