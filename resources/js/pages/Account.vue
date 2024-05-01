<template>
    <app-layout>
        <div class="q-pa-md">
            <div class="text-h4 text-orange-8 pocket-monk">Update profile</div>
        </div>
        <div class="q-px-lg">
            <div class="row" >
                <div class="col-md-6" >
                    <q-card>
                        <q-card-section>
                            <div class="text-h5">Personal Information</div>
                        </q-card-section>
                        <q-separator />
                        <q-card-section>
                            <q-form @submit.prevent="updateProfile">
                                <div>
                                    <q-input label="First Name" v-model="user_data.first_name" />
                                </div>
                                <div>
                                    <q-input label="Middle Name" v-model="user_data.middle_name" />
                                </div>
                                <div>
                                    <q-input label="Last Name" v-model="user_data.last_name" />
                                </div>
                                <div>
                                    <q-input label="Birthdate" type="date" v-model="user_data.birthdate" />
                                </div>
                                <div>
                                    <q-input label="Hobbies" v-model="user_data.hobbies" />
                                </div>
                                <div class="text-right q-mt-sm">
                                    <q-btn color="amber" label="submit" type="submit" />
                                </div>
                            </q-form>
                        </q-card-section>
                    </q-card>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import _default from 'vuex';
    import Layout from '../layout/MainLayout.vue';
    import { Notify } from 'quasar';  

    export default {
        data: () => {
            return {
                user_data: JSON.parse(localStorage.getItem('user_data')),
            }
        },
        methods: {
            async updateProfile(){
                let {data, status} = await this.$api.updateProfile(this.user_data);
        
                    if([200, 201].includes(status)){
                        Notify.create({
                            message: data.message,
                            position: 'top-right',
                            closeBtn: "X",
                            timeout: 2000,
                            color: 'green',
                        });

                        localStorage.setItem('user_data',JSON.stringify(this.user_data));
                    } else {
                        Notify.create({
                            message: data.message,
                            position: 'top-right',
                            closeBtn: "X",
                            timeout: 2000,
                            color: 'red',
                        });
                    }
            }
        },
        components: {
            appLayout: Layout,
        }
    }
</script>