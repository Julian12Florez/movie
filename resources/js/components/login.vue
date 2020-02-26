<template>
  <v-app id="inspire">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>Login form</v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
              <v-card-text>
                <v-form>
                  <v-text-field label="username" v-model="username" type="text"></v-text-field>

                  <v-text-field id="password" v-model="password" label="Password" type="password"></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="login()">Login</v-btn>
                <v-btn color="primary" :to="{ path: '/'}">Register user</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import axios from "axios";
export default {
  name: "login",
  props: [],
  mounted() {},
  data() {
    return {
      username: "",
      password: ""
    };
  },
  methods: {
    async login() {
      try {
        let response = await axios.post("api/auth/login", {
          nickname: this.username,
          password:this.password
        });
        if (response.data.status) {
          localStorage.setItem("token",response.data.token)
          this.$router.push("allMovies");
        }else{
            alertify.error("Error en la autenticación")
        }
      } catch (error) {
          alertify.error("Error en la autenticación")
        console.log("Error redirect");
      }
    },
  },
  computed: {}
};
</script>
