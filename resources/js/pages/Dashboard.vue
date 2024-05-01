<template>
    <app-layout>
        <div class="q-pa-md">
            <div class="text-h4 text-orange-8 pocket-monk">Choose your pokemon!</div>
            
            <div class="bg-orange-8" style="width: 400px; height: 100vh; overflow: auto; right: 0; top: 0; z-index: 2000; position: fixed;" v-if="selected_pokemon">
                <app-pokemon-card :selected_pokemon.sync="selected_pokemon" :hide_buttons="false" @closeModal="selected_pokemon = null" />
            </div>
            <div class="container row">
                <div class="col-lg-2 col-md-2 col-sm-6 col-xs-12" v-for="(item, key) in all_pokemons" :key="key">
                    <div class="q-pa-sm">
                        <div class="bg-white full-width q-pa-md">
                            <div class="text-center text-uppercase q-pb-md" style="font-size: 14pt;">
                                {{ item.name }}
                            </div>
                            <div class="text-center">
                                <q-btn label="View" @click="viewPokemon(item.url)" color="orange-8" dense glossy icon="catching_pokemon" class="full-width"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-between q-py-md">
                <q-btn color="amber" label="PREVIOUS" icon="arrow_back" :disable="!previous || is_loading" @click="onClickPrevious" />
                <q-btn color="amber" label="NEXT" icon-right="arrow_forward" :disable="!next || is_loading" @click="onClickNext" />
            </div>
        </div>
    </app-layout>
</template>
<script>
    import Layout from '../layout/MainLayout.vue';
    import PokemonCard from '../components/PokemonCard.vue';
    export default {
        data: () => {
            return {
                offset: 0,
                limit: 60,
                page: 0,

                user_data: JSON.parse(localStorage.getItem('user_data')),

                all_pokemons: [],
                next: null,
                previous: null,

                is_loading: false,
                open_pokemon_modal: false,
                selected_pokemon: null,
            }
        },
        methods: {
            async getPokemons(){
                let payload = {
                    limit: this.limit,
                    offset: this.offset
                }

                this.is_loading = true;
                let {data, status} = await this.$api.getPokemon(payload);

                if([200, 201].includes(status)){
                    this.all_pokemons = data.results
                    this.next = data.next;
                    this.previous = data.previous;
                }
                this.is_loading = false;
            },

            async viewPokemon(url){
                this.is_loading = true;
                let {data, status} = await this.$api.call(url);
                if([200, 201].includes(status)){
                    this.open_pokemon_modal = true;
                    this.selected_pokemon = data;
                    this.selected_pokemon.show_moves = false;
                    this.is_loading = false;
                    console.log(data);
                }
            },

            onClickNext(){
                this.page++;
                this.offset = this.page * this.limit;
                this.getPokemons();
            },

            onClickPrevious(){
                this.page = this.page-1;
                this.offset = this.page * this.limit;
                this.getPokemons();
            }
        },
        
        mounted(){
            this.getPokemons();
        },
        components: {
            appLayout: Layout,
            appPokemonCard: PokemonCard,
        }
    }
</script>