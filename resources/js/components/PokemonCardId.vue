<template>
    <div class="pokemon-details-holder pocket-monk" style="position: relative; border: 1px solid lightgrey;" v-if="selected_pokemon">
        <div style="padding-left: 10px; padding-right: 10px;" class="flex justify-between">
            <span class="text-h6">{{ selected_pokemon.name }}</span>
            <span class="text-h6 text-amber">{{ selected_pokemon.base_experience }} <q-avatar color="amber" style="font-size: 17pt; rotate: 20deg;" class="text-white"><q-icon name="bolt" /></q-avatar></span>
        </div>
        <div class="text-center full-width q-pa-sm bg-grey-1">
            <img :src="selected_pokemon.sprites.other['official-artwork'].front_default" style="width: 60%;" />
        </div>
        <div class="q-py-md">
            <span>
                Abilities: 
                <span class="text-grey-9">{{ selected_pokemon.abilities.map((i) => {
                    return i.ability.name.replaceAll("-", " ");
                }).join(", ") }}</span>
            </span>
        </div>
        <div class="stats">
            <div class="stats_holder q-mb-sm" v-for="(stat, k) in selected_pokemon.stats" :key="k">
                <div>
                    <div class="flex justify-between">
                        <span>{{ stat.stat.name }}</span> <span class="text-orange-5">({{ stat.base_stat+'%' }})</span>
                    </div>
                    <q-linear-progress size="10px" color="amber" :value="stat.base_stat+'%'" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Notify } from 'quasar';  
    export default {
        props: {
            pokemon_id: {
                type: Number,
                required: true,
            },
        },
        data: () => {
            return {
                offset: 0,
                limit: 60,
                page: 0,

                user_data: JSON.parse(localStorage.getItem('user_data')),
                selected_pokemon: null,
            }
        },
        methods: {
            async getSpecificPokemon(){
                let {data, status} = await this.$api.call(`https://pokeapi.co/api/v2/pokemon/${this.pokemon_id}`);
                if([200, 201].includes(status)){
                    this.selected_pokemon = data;
                }

            },
        },
        mounted(){
            this.getSpecificPokemon();
            // pokemon_id
        }
    }
</script>