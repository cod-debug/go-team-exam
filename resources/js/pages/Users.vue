<template>
    <app-layout>
        <div class="q-pa-md">
            <div class="text-h4 text-orange-8 pocket-monk">Checkout your friends!</div>
        </div>
        <div class="q-px-lg">
            <q-card>
                <q-card-section>
                    <div class="row" style="height: 80vh; overflow: auto;">
                        <div style="border-right: 1px solid #dadada;" class="col-md-2 col-sm-4">
                            <q-card v-for="(item, key) in user_list" :key="key" class="full-width text-left cursor-pointer q-my-sm" @click="viewDetails(item)">
                                <q-card-section>
                                    {{ item.first_name }} {{ item.last_name }}
                                </q-card-section>
                            </q-card>
                        </div>
                        <div class="col-md-10 q-pa-md col-sm-8" style="flex-grow: 1;">
                            <div class="row" v-if="selected_user">
                                <div class="col-md-8">
                                    <div class="q-pa-sm">
                                        <q-card class="full-width">
                                            <q-card-section>
                                                <div class="text-h6">Personal Info</div>
                                            </q-card-section>
                                            <q-separator />
                                            <q-card-section>
                                                <div class="row">
                                                    <q-input readonly label="First Name" v-model="selected_user.first_name" class="q-px-sm"/>
                                                    <q-input readonly label="Middle Name" v-model="selected_user.middle_name" class="q-px-sm"/>
                                                    <q-input readonly label="Last Name" v-model="selected_user.last_name" class="q-px-sm"/>
                                                </div>
                                                <div>
                                                    <q-input type="date" v-model="selected_user.birthdate" readonly label="Birthdate" class="q-px-sm" />
                                                </div>
                                                <div>
                                                    <q-input type="text" v-model="selected_user.hobbies" readonly label="Hobbies" class="q-px-sm" />
                                                </div>
                                                <div>
                                                    <q-input type="email" v-model="selected_user.email" readonly label="Email Address" class="q-px-sm" />
                                                </div>
                                            </q-card-section>
                                        </q-card>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="q-pa-sm">
                                        <q-card class="full-width">
                                            <q-card-section>
                                                <div class="text-h6">Pokemons</div>
                                            </q-card-section>
                                            <q-separator />
                                            
                                            <q-card-section>

                                            <q-tabs
                                                v-model="tab"
                                                dense
                                                align="justify"
                                                class="bg-orange-7 text-white shadow-2"
                                                :breakpoint="0"
                                                >
                                                <q-tab name="likes" label="Likes" icon="favorite" />
                                                <q-tab name="dislikes" label="Dislikes" icon="thumb_down" />
                                            </q-tabs>
                                                <div v-if="tab === 'likes'">
                                                    <div v-if="selected_user.pokemons.likes">
                                                        <div v-for="(item, key) in selected_user.pokemons.likes" :key="key" class="col-md-4">
                                                            <app-pokemon-card-id :pokemon_id="item" />
                                                        </div>
                                                    </div>
                                                    <div v-else class="q-pa-md">
                                                        No pokemon found.
                                                    </div>
                                                </div>
                                                <div v-if="tab === 'dislikes'">
                                                    <div v-if="selected_user.pokemons.dislikes">
                                                        <div v-for="(item, key) in selected_user.pokemons.dislikes" :key="key" class="col-md-4">
                                                            <app-pokemon-card-id :pokemon_id="item" />
                                                        </div>
                                                    </div>
                                                    <div v-else class="q-pa-md">
                                                        No pokemon found.
                                                    </div>
                                                </div>
                                            </q-card-section>
                                        </q-card>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </q-card-section>
            </q-card>
        </div>
    </app-layout>
</template>

<script>
    import Layout from '../layout/MainLayout.vue';
    import PokemonCardId from '../components/PokemonCardId.vue';
    export default {
        data: () => {
            return {
                tab: "likes",
                limit: 10,
                user_list: [],
                user_data: JSON.parse(localStorage.getItem('user_data')),
                selected_user: null,
            }
        },
        methods: {
            viewDetails(item){
                this.selected_user = null;
                this.tab = "";
                this.$nextTick(() => {
                    this.selected_user = item;
                    this.tab = "likes";
                });
            },
            async getUserList(){
                let payload = {
                    limit: this.limit,
                    user_id: this.user_data.id
                }

                let {data, status} = await this.$api.userList(payload);
                if([200, 201].includes(status)){
                    this.user_list = data.data;
                }
                // userList
            }
        },
        components: {
            appLayout: Layout,
            appPokemonCardId: PokemonCardId,
        },
        mounted(){
            this.getUserList();
        },
    }
</script>