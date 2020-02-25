<template >
 <v-app id="inspire">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md4>
            <v-card class="elevation-12">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>Register form</v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
              <v-card-text>
                <v-form>
                   <v-text-field
                    v-model="name"
                    :rules="nameRules"
                    label="Name"
                    required
                  ></v-text-field>
                  <v-text-field
                    v-model="email"
                    label="E-mail"
                    required
                  ></v-text-field>
                  <v-text-field
                    v-model="nickname"
                    :rules="nicknameRules"
                    label="nickname"
                    required
                  ></v-text-field>
                  <v-text-field
                    v-model="password"
                    :rules="passRules"
                    label="Password"
                    counter
                    required
                  ></v-text-field>
                </v-form>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color="primary" @click="register()">Register user</v-btn>
                <v-btn color="primary" :to="{ path: '/login'}">Sign in</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>
  </v-app>
</template>


<script >

  export default  {
    name: 'register',
    props: [],
    mounted () {

    },
    data () {
      return {
        name: '',
        email:'',
       nameRules: [
          v => !!v || 'El nombre es obligatorio',
          v => v.length >= 5 || 'El nombre debe contener minimo 5 caracteres',
        ],
        nickname: '',
        nicknameRules: [
          v => !!v || 'El nombre es obligatorio',
          v => v.length >= 5 || 'El nombre debe contener minimo 5 caracteres',
        ],
        password: '',
        passRules: [
            value => !!value || 'Contraseña Requerida',
            v => v.length >= 8 || 'Min 8 caracteres',
        ]
    } 
    },
    methods: {
      async register() {
      try {
        let response = await axios.post("api/app/register", {
          name: this.name,
          nickname: this.nickname,
          password: this.password,
          email:`${this.nickname}@test.com`
        });
        this.$router.push("/login");
      } catch (error) {
        console.log("Error");
      }
    }
    },
   
}


</script>

