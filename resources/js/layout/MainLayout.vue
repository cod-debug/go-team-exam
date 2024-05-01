<template>
    <div class="wrapper">
        <div class="sidebar">
            <div class="logo-details">
                <div class="logo_name"><img src="/assets/images/logo.png" alt="pokeball" style="width: 120px;" /></div>
                <i id="btn">
                    <q-icon name="menu" />
                </i>
            </div>
            <ul class="nav-list">
                <li>
                    <a class="cursor-pointer" @click="$router.get('dashboard')">
                        <i class='bx bx-grid-alt'>
                            <q-icon name="catching_pokemon" />
                        </i>
                        <span class="links_name pocket-monk">All Pokemons</span>
                    </a>
                    <span class="tooltip">All Pokemons</span>
                </li>
                <li>
                    <a class="cursor-pointer" @click="$router.get('users')">
                        <i class='bx bx-user'>
                            <q-icon name="people" />
                        </i>
                        <span class="links_name pocket-monk">Users</span>
                    </a>
                    <span class="tooltip">User</span>
                </li>
                <li class="profile cursor-pointer" @click="logout" >
                    <div class="profile-details">
                        <i class='bx bx-user'>
                            <q-icon name="logout" />
                        </i>
                    <div class="name_job">
                        <div class="name">Logout</div>
                    </div>
                    </div>
                    <i class='bx bx-log-out' id="log_out"></i>
                </li>
            </ul>
        </div>
        <section class="home-section relative">
            <slot />
        </section>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
    data: () => {
        return {
            drawerLeft: true,
        }
    },
    methods:{
        logout(){
            localStorage.clear();
            this.$router.get('/');
        }
    },
    components: {
        Link,
    },
    mounted(){
        let sidebar = document.querySelector(".sidebar");
        let closeBtn = document.querySelector("#btn");

        closeBtn.addEventListener("click", () => {
        sidebar.classList.toggle("open");
        menuBtnChange();
        });

        function menuBtnChange() {
        if (sidebar.classList.contains("open")) {
            closeBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else {
            closeBtn.classList.replace("bx-menu-alt-right", "bx-menu");
        }
        }

    },
}
</script>