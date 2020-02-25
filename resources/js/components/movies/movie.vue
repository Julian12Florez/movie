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
              ></v-data-table>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                    <v-btn   color="primary"   dark   @click.stop="dialog = true" >Register movie </v-btn>
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
                <v-toolbar-title>Register form</v-toolbar-title>
                <v-spacer></v-spacer>
              </v-toolbar>
          <v-card-text>
                 <v-form>
                   <v-text-field
                    v-model="title"
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
                </v-form>
          </v-card-text>
  
          <v-card-actions>
            <v-spacer></v-spacer>
  
            <v-btn
              color="primary darken-1"
              text
              @click="register()"
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
          { text: 'Year', value: 'year' }
        ],
        items:[]
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
    async register() {
      try {  
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token')
        let response = await axios.post("api/movies/movies", {
          title: this.title,
          sinopsis: this.sinopsis,
          year: this.year_movie
        });
        
         this.getMovies()
         this.dialog = false
      } catch (error) {
        console.log("Error login");
      }
    },
    // this.$refs.form.reset()
    },
    computed: {

    },
    mounted(){
      console.log("object")
      this.getMovies()
    }
}


</script>

