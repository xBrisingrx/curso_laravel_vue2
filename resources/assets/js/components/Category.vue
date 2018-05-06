<template>
  <main class="main">
      <!-- Breadcrumb -->
      <ol class="breadcrumb">
          <li class="breadcrumb-item">Home</li>
          <li class="breadcrumb-item"><a href="#">Admin</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
      </ol>
      <div class="container-fluid">
          <!-- Ejemplo de tabla Listado -->
          <div class="card">
              <div class="card-header">
                  <i class="fa fa-align-justify"></i> Categorías
                  <button type="button" @click="openModal('category', 'store')" class="btn btn-secondary">
                      <i class="icon-plus"></i>&nbsp;Nuevo
                  </button>
              </div>
              <div class="card-body">
                  <div class="form-group row">
                      <div class="col-md-6">
                          <div class="input-group">
                              <select class="form-control col-md-3" id="opcion" name="opcion">
                                <option value="nombre">Nombre</option>
                                <option value="descripcion">Descripción</option>
                              </select>
                              <input type="text" id="texto" name="texto" class="form-control" placeholder="Texto a buscar">
                              <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                          </div>
                      </div>
                  </div>
                  <table class="table table-bordered table-striped table-sm">
                      <thead>
                          <tr>
                              <th>Opciones</th>
                              <th>Nombre</th>
                              <th>Descripción</th>
                              <th>Estado</th>
                          </tr>
                      </thead>
                      <tbody>
                          <tr v-for="category in arrayCategory" :key="category.id">
                              <td>
                                  <button type="button" @click="openModal('category', 'update', category)" class="btn btn-warning btn-sm">
                                    <i class="icon-pencil"></i>
                                  </button> &nbsp;
                                  <template v-if="category.active">
                                    <button @click="categoryDesactivate(category.id)" type="button" class="btn btn-danger btn-sm">
                                      <i class="icon-trash"></i>
                                    </button>
                                  </template>
                                  <template v-else>
                                    <button @click="categoryActivate(category.id)" type="button" class="btn btn-info btn-sm">
                                      <i class="fa fa-check"></i>
                                    </button>
                                  </template>
                              </td>
                              <td v-text="category.name"></td>
                              <td v-text="category.description"></td>
                              <td>
                                  <div v-if="category.active">
                                    <span class="badge badge-success">Activo</span>
                                  </div>
                                  <div v-else>
                                    <span class="badge badge-danger">Inactivo</span>
                                  </div>
                              </td>
                          </tr>
                      </tbody>
                  </table>
                  <nav>
                      <ul class="pagination">
                          <li class="page-item">
                              <a class="page-link" href="#">Ant</a>
                          </li>
                          <li class="page-item active">
                              <a class="page-link" href="#">1</a>
                          </li>
                          <li class="page-item">
                              <a class="page-link" href="#">2</a>
                          </li>
                          <li class="page-item">
                              <a class="page-link" href="#">3</a>
                          </li>
                          <li class="page-item">
                              <a class="page-link" href="#">4</a>
                          </li>
                          <li class="page-item">
                              <a class="page-link" href="#">Sig</a>
                          </li>
                      </ul>
                  </nav>
              </div>
          </div>
          <!-- Fin ejemplo de tabla Listado -->
      </div>
      <!--Inicio del modal agregar/actualizar-->
      <div class="modal fade" tabindex="-1" :class="{'show' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
          <div class="modal-dialog modal-primary modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title" v-text="modalTitle"></h4>
                      <button type="button" class="close" aria-label="Close" @click="closeModal()">
                        <span aria-hidden="true">×</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                          <div class="form-group row">
                              <label class="col-md-3 form-control-label" for="text-input">Nombre (*)</label>
                              <div class="col-md-9">
                                  <input type="text" v-model="name" class="form-control" placeholder="Nombre de categoría">
                              </div>
                          </div>
                          <div class="form-group row">
                              <label class="col-md-3 form-control-label" for="email-input">Descripción</label>
                              <div class="col-md-9">
                                  <input type="text" v-model="description" class="form-control" placeholder="Ingrese descripcion">
                              </div>
                          </div>
                          <div v-show="categoryError" class="form-group row div-error">
                            <div class="text-center text-error">
                              <div v-for="error in categoryErrorMsg" :key="error" v-text="error"></div>
                            </div>
                          </div>
                      </form>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" @click="closeModal()">Cerrar</button>
                      <button v-if="actionType==1" type="button" class="btn btn-primary" @click="storeCategory()">Guardar</button>
                      <button v-if="actionType==2" type="button" class="btn btn-primary" @click="updateCategory()">Actualizar</button>
                  </div>
              </div>
              <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>
      <!--Fin del modal-->
      <!-- Inicio del modal Eliminar -->
      <div class="modal fade" id="modalEliminar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
          <div class="modal-dialog modal-danger" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h4 class="modal-title">Eliminar Categoría</h4>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                      </button>
                  </div>
                  <div class="modal-body">
                      <p>Estas seguro de eliminar la categoría?</p>
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                      <button type="button" class="btn btn-danger">Eliminar</button>
                  </div>
              </div>
              <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
      </div>
      <!-- Fin del modal Eliminar -->

  </main>
</template>

<script>
  export default {
    data(){
      return {
        category_id : 0,
        name : '',
        description : '',
        arrayCategory: [],
        modal : 0,
        modalTitle : '',
        actionType : 0,
        categoryError : 0,
        categoryErrorMsg : [],
      }
    },
    methods : {
      categoryList(){
        let me = this
        axios.get('index.php/category').then( function (response){
          me.arrayCategory = response.data
        })
        .catch(function(error){
          console.log(error)
        })
      },
      storeCategory(){
        if (this.validateCategory()) {
          return
        } 
        let me = this
          axios.post('index.php/category/store', {
            'name': this.name,
            'description': this.description
          }).then(function(response){
            me.closeModal()
            me.categoryList()
          }).catch(function(error){
            console.log(error)
          })
      },
      updateCategory(){
        if (this.validateCategory()) {
          return
        }
        let me = this
          axios.put('index.php/category/update', {
            'name': this.name,
            'description': this.description,
            'id' : this.category_id
          }).then(function(response){
            me.closeModal()
            me.categoryList()
          }).catch(function(error){
            console.log(error)
          })
      },
      // Validamos que el name no sea vacio
      validateCategory(){
        this.categoryError = 0
        this.categoryErrorMsg = []
        // Si el nombre esta vacio asignamos el msg de error al array
        if (!this.name) this.categoryErrorMsg.push('El nombre de la categoria no puede estar vacio.') 
        // Si el array tiene un mensaje adentro categoryError le asignamos true/1
        if(this.categoryErrorMsg.length) this.categoryError = 1
        return this.categoryError
      },
      closeModal(){
        this.modal = 0
        this.modalTitle = ''
        this.name = ''
        this.description = ''
        this.categoryError = 0
        this.categoryErrorMsg = []
      },
      openModal(model, action, data = []){
        switch(model) {
          case "category":
          {
            switch(action){
              case "store":
              {
                this.actionType = 1
                this.modal = 1
                this.modalTitle = 'Registrar categoria'
                this.name = ''
                this.description = ''
                break
              }
              case "update":
              {
                this.actionType = 2
                this.modal = 1
                this.modalTitle = 'Actualizar categoria'
                this.category_id = data.id
                this.name = data.name
                this.description = data.description
                break
              }
            }
          }
        }
      }, // end openModal
      categoryDesactivate(id){
        swal({
          title: "Estas seguro de desactivar esta categoria?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            let me = this
            axios.put('index.php/category/deactivate', {
              'id' : id
            }).then(function(response){
              swal("Categoria desactivada!", {
              icon: "success",
              });
              me.categoryList()
            }).catch(function(error){
              console.log(error)
            })
          }
        });
      },
      categoryActivate(id){
        swal({
          title: "Estas seguro de activar esta categoria?",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            let me = this
            axios.put('index.php/category/activate', {
              'id' : id
            }).then(function(response){
              swal("Categoria activada!", {
              icon: "success",
              });
              me.categoryList()
            }).catch(function(error){
              console.log(error)
            })
          }
        });
      }
    },
    mounted() {
      this.categoryList()
    }
  }
</script>

<style>
  .modal-content{
    width: 100% !important;
    position: absolute !important;
  }
  .show{
    display: list-item !important;
    opacity: 1 !important;
    position: absolute !important;
    background-color: #3c29297a !important;
  }
  .div-error{
    display: flex;
    justify-content: center;
  }
  .text-error{
    color: red !important;
    font-weight: bold;
  }
</style>