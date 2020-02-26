<template>
<v-app id="inspire">
    <v-content>
      <v-container fluid fill-height>
        <v-layout align-center justify-center>
          <v-flex xs12 sm8 md8>
            <v-card class="elevation-12">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>All movies</v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
              <v-card-text>
                <v-data-table
                :headers="headers"
                :items="items"
                :items-per-page="5"
                class="elevation-1"
              >
        <template v-slot:item.action="{ item }">
        <v-icon
          small
          class="mr-2"
          @click="editItem(item)"
        >
          edit
        </v-icon>
        <v-icon
          small
          @click="deleteItem(item)"
        >
          delete
        </v-icon>
      </template>
              </v-data-table>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                    <v-btn   color="primary"   dark   @click.stop="dialog = true" >Register form</v-btn>
              </v-card-actions>
            </v-card>
          </v-flex>
        </v-layout>
      </v-container>
    </v-content>


      <!-- Modal -->
     <v-dialog
        v-model="dialog"
        width="500"
      >
        <v-card>
           <v-toolbar color="primary" dark flat>
                <v-toolbar-title>{{header_title}}</v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
          <v-card-text>
                 <v-form>
                <form>
                   <v-text-field
                    v-model="title"
                    :rules="titleRules"
                    label="Title"
                    required
                  ></v-text-field>
                  <v-text-field
                    v-model="sinopsis"
                    label="Sinopsis"
                  ></v-text-field>
                  <v-text-field
                    v-model="year_movie"
                    label="Year"
                    required
                  ></v-text-field>
                  </form>
                </v-form>
          </v-card-text>

          <v-card-actions>
            <v-spacer></v-spacer>

            <v-btn
              color="primary darken-1"
              text
              @click="saveMovies()"
            >
              Save
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>

  </v-app>
</template>

<script>
import axios from "axios";
  export default  {
    name: 'movie',
    props: [],
    mounted () {

    },
      data () {
      return {
        titleRules:[
            v=>!!v || "El titulo es requerido"
        ],
        title:'',
        sinopsis:'',
        year_movie:'',
        dialog:false,
        headers: [
          {
            text: 'Title',
            align: 'start',
            sortable: false,
            value: 'title',
          },
          { text: 'Sinopsis', value: 'sinopsis' },
          { text: 'Year', value: 'year' },
         { text: 'Actions', value: 'action', sortable: false },
        ],
        items:[],
        update_action:false,
        id:'',
        header_title:'Register form',
        action:''
      }
    },
    methods: {
      async getMovies() {
          try {
          axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
          let response = await axios.get("api/movies/movies");
          this.items=response.data;
        } catch (error) {
         this.$router.push("/login")
          console.log("Error");
        }
    },
    async saveMovies() {
      try {
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        if (!this.update_action) {
            this.action="api/movies/movies";
            await this.storeMovies();
        } else {
            this.action=`api/movies/movies/${this.id}`
            await this.updateMovies()
        }
        if(this.response.data.status){
            this.getMovies()
            this.dialog = false
            alertify.success(`${this.response.data.msg}`)
            this.update_action=false;
            this.header_title="Register form"
            this.clearForm();
        }
      } catch (error) {
          alertify.warning("Ocurrio un error en el proceso")
        console.log("Error login");
      }
    },
    async editItem(item){
        this.update_action=true;
        this.id=item.id;
        this.title=item.title;
        this.sinopsis=item.sinopsis;
        this.year_movie=item.year;
        this.header_title="Update form"
        this.dialog=true
    },
    async storeMovies(){
        this.response=await axios.post(this.action, {
          title: this.title,
          sinopsis: this.sinopsis,
          year: this.year_movie
    })
    },
     async updateMovies(){
        this.response= await axios.patch(this.action, {
          title: this.title,
          sinopsis: this.sinopsis,
          year: this.year_movie
    });
    },
    async deleteItem(item){
          axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
          let response = await axios.delete(`api/movies/movies/${item.id}`);
          if (response.data.status) {
                this.getMovies()
              alertify.warning(response.data.msg)
          } else {

          }
    },
    clearForm(){
        this.title="",
        this.sinopsis="",
        this.year_movie=""
    }
    },
    computed: {

    },
    mounted(){
      console.log("object")
      this.getMovies()
    }
}


</script>

