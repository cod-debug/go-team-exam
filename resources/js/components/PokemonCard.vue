<template>
    <div>
        <div class="q-py-md flex justify-evenly" v-if="!hide_buttons">
            <q-btn icon="favorite_border" color="green-5" @click="likePokemon(true)" />
            <q-btn icon="thumb_down_off_alt" color="red-5" @click="likePokemon(false)" />
            <q-btn icon="close" color="warning" @click="$emit('closeModal')" />
        </div>
        <div class="pokemon-details-holder pocket-monk" style="position: relative;">
            <q-avatar color="green-2" class="absolute" style="top: -.8rem; left: -.8rem;z-index: 1;">
                <img :src="selected_pokemon.sprites.front_default" class="full-width" />
            </q-avatar>
            <div style="padding-left: 30px; padding-right: 10px;" class="flex justify-between">
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
            <div class="q-pt-md moves">
                <div class="cursor-pointer" @click="selected_pokemon.show_moves = !selected_pokemon.show_moves">{{ selected_pokemon.show_moves ? 'Hide' : 'Show' }}  Moves</div>
                <span v-if="selected_pokemon.show_moves">
                    <span class="text-grey-9">{{ selected_pokemon.moves.map((i) => {
                        return i.move.name.replaceAll("-", " ");
                    }).join(", ") }}</span>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
import { Notify } from 'quasar';  
    export default {
        props: {
            selected_pokemon: {
                type: Object,
                required: true,
            },
            hide_buttons: {
                type: Boolean,
                default: false,
            }
        },
        data: () => {
            return {
                offset: 0,
                limit: 60,
                page: 0,

                user_data: JSON.parse(localStorage.getItem('user_data')),
            }
        },
        methods: {
            async likePokemon(like){
                let payload = {
                    user_id: this.user_data.id,
                    pokemon_id: this.selected_pokemon.id,
                }    

                if(like){
                    var { data, status } = await this.$api.likePokemon(payload);
                } else {
                    var { data, status } = await this.$api.dislikePokemon(payload);
                }

                if([200, 201].includes(status)){
                    Notify.create({
                        message: data.message,
                        position: 'top-right',
                        closeBtn: "X",
                        timeout: 2000,
                        color: 'green',
                    });
                } else {
                    Notify.create({
                        message: data.message,
                        position: 'top-right',
                        closeBtn: "X",
                        timeout: 2000,
                        color: 'red',
                    });
                }
            },

        }
    }
</script>