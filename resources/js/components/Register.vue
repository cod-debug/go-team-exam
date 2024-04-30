<template>
    <q-form class="full-width q-pa-xl" @submit.prevent="submitRegister" ref="form" greedy>
        <div class="text-center q-pa-lg"
            style="font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;">
            <img src="/assets/images/logo.png" alt="pokeball" style="width: 300px;" />
            <div class=" text-orange-6 text-h4">Create account now!</div>
        </div>
        <div class="full-width q-py-sm">
            <div class="row">
                <div class="col-md-4">
                    <div class="q-pr-sm">
                        <q-input rounded outlined v-model="first_name" label="First Name" :rules="[
                            val => val && val.length > 0 || 'First Name is required',
                        ]" />
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="q-pr-sm">
                        <q-input rounded outlined v-model="middle_name" label="Middle Name" :rules="[
                            val => val && val.length > 0 || 'Middle Name is required',
                        ]" />
                    </div>
                </div>
                <div class="col-md-4">
                    <q-input rounded outlined v-model="last_name" label="Last Name" :rules="[
                        val => val && val.length > 0 || 'Last Name is required',
                    ]" />
                </div>
            </div>
        </div>
        <div class="full-width q-pb-sm">
            <div class="row">
                <div class="col-md-6">
                    <div class="q-pr-sm">
                        <q-input rounded outlined v-model="birthdate" label="Birtdate" type="date" stack-label :rules="[
                            val => val && val.length > 0 || 'Birtdate is required',
                        ]" />
                    </div>
                </div>
                <div class="col-md-6">
                    <div>
                        <q-input rounded outlined v-model="hobbies" label="Hobbies" :rules="[
                            val => val && val.length > 0 || 'Hobbies field is required',
                        ]" />
                    </div>
                </div>
            </div>
        </div>
        <div class="full-width">
            <div class="row">
                <div class="col-md-6">
                    <div class="q-pr-sm">
                        <q-input rounded outlined v-model="email" label="Email" type="email" :rules="[
                            val => val && val.length > 0 || 'Email address is required',
                        ]" />
                    </div>
                </div>
                <div class="col-md-6">
                    <q-input rounded outlined v-model="username" label="Username" :rules="[
                        val => val && val.length > 0 || 'Username is required',
                    ]" />
                </div>
            </div>
        </div>
        <div class="full-width q-py-sm">
            <q-input rounded outlined v-model="password" label="Password" :type="show_password ? 'text' : 'password'"
                :rules="[
                    val => val && val.length > 0 || 'Password is required',
                ]">
                <template v-slot:append>
                    <q-btn round dense flat :icon="show_password ? 'visibility' : 'visibility_off'"
                        @click="show_password = !show_password" />
                </template>
            </q-input>
        </div>
        <div class="full-width q-py-sm flex items-center justify-between q-pl-sm">
            <div class="text-h6 text-grey-8">Sign up</div>
            <q-btn type="submit" style="aspect-ratio: 1/1; border-radius: 50%;" icon="arrow_forward" color="orange-8"
                glossy />
        </div>
        <div class="text-center">
            <span class="text-grey-7">Already have an account? <span @click="back"
                    class="text-orange-8 cursor-pointer">Sign
                    in</span></span>
        </div>
    </q-form>
</template>

<script>
import { Notify } from 'quasar';
import axios from 'axios';
export default {
    data: () => {
        return {
            first_name: "",
            middle_name: "",
            last_name: "",
            birthdate: null,
            hobbies: "",
            email: "",
            username: "",
            password: "",
            show_password: false,

        }
    },
    methods: {
        async submitRegister() {
            let valid = await this.$refs.form.validate();
            if (!valid) {
                return false;
            }

            let payload = {
                first_name: this.first_name,
                middle_name: this.middle_name,
                last_name: this.last_name,
                birthdate: this.birthdate,
                hobbies: this.hobbies,
                email: this.email,
                username: this.username,
                password: this.password
            }

            let {data, status} = await axios({
                method: "post",
                url: `/api/auth/register`,
                data: payload,
                headers: {
                    "Content-Type": "application/json; charset=utf-8"
                },
            });

            console.log(data);
        },
        back() {
            this.$emit('openLogin');
        }
    },
}
</script>
