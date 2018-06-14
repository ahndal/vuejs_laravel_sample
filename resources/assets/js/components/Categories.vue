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
                    <button type="button" @click="openModal('category', 'write')" class="btn btn-secondary">
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="input-group">
                                <select class="form-control col-md-3" v-model="option">
                                    <option value="name">이름</option>
                                    <option value="description">설명</option>
                                </select>
                                <input type="text" v-model="keyword" keyup.enter="listCategories(1, option, keyword)" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" @click="listCategories(1, option, keyword)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped table-sm">
                        <thead>
                            <tr>
                                <th>option</th>
                                <th>name</th>
                                <th>description</th>
                                <th>status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="category in categories" :key="category.id">
                                <td>
                                    <button type="button" @click="openModal('category', 'update', category)" class="btn btn-warning btn-sm">
                                        <i class="icon-pencil"></i>
                                    </button> &nbsp;
                                    <template v-if="category.status">
                                        <button type="button" @click="desactivarCategory(category.id)" class="btn btn-danger btn-sm">
                                            <i class="icon-trash"></i> 
                                        </button>
                                    </template>
                                    <template v-else>
                                        <button type="button" @click="activarCategory(category.id)" class="btn btn-info btn-sm">
                                            <i class="icon-check"></i> 
                                        </button>
                                    </template>
                                </td>
                                <td>{{ category.name }}</td>
                                <td>{{ category.description }}</td>
                                <td>
                                    <div v-if="category.status">
                                        <span class="badge badge-success">활성화</span>
                                    </div>
                                    <div v-else>
                                        <span class="badge badge-danger">비활성화</span>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="changePaging(pagination.current_page - 1, option, keyword)">&lt;</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                <a class="page-link" href="#" @click.prevent="changePaging(page, option, keyword)">{{page}}</a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="changePaging(pagination.current_page + 1, option, keyword)">&gt;</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'is_show': modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{modalTitle}}</h4>
                        <button type="button" class="close"  @click="closeModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">이름</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="name" class="form-control" placeholder="name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="email-input">설명</label>
                                <div class="col-md-9">
                                    <input type="text" v-model="description" class="form-control" placeholder="description">
                                </div>
                            </div>
                            <div v-show="error" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="errorMsg in errorMsgs" :key="errorMsg">{{ errorMsg }}</div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" @click="closeModal()">닫기</button>
                        <button type="button" v-if="defaultAction==1" class="btn btn-primary" @click="writeCategory()">확인</button>
                        <button type="button" v-if="defaultAction==2" class="btn btn-primary" @click="updateCategory()">수정</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!--Fin del modal-->
    </main>
</template>

<script>
export default {
  data() {
    return {
      name: '',
      description: '',
      categories: [],
      modal: 0,
      modalTitle: '',
      defaultAction: 0,
      error: 0,
      errorMsgs: [],
      pagination: {
        total: 0,
        current_page: 0,
        per_page: 0,
        last_page: 0,
        from: 0,
        to: 0
      },
      offset: 3,
      option: 'name',
      keyword: ''
    };
  },
  computed: {
    isActived: function() {
      return this.pagination.current_page;
    },
    pagesNumber: function() {
      if (!this.pagination.to) {
        return [];
      }

      let from = this.pagination.current_page - this.offset;
      if (from < 1) {
        from = 1;
      }

      let to = from + this.offset * 2;
      if (to >= this.pagination.last_page) {
        to = this.pagination.last_page;
      }

      let pagesArray = [];
      while (from <= to) {
        pagesArray.push(from);
        from++;
      }

      return pagesArray;
    }
  },
  methods: {
    listCategories(page, option, keyword) {
      let me = this;
      let url =
        "/categories?page=" +
        page +
        "&option=" +
        option +
        "&keyword=" +
        keyword;

      axios
        .get(url)
        .then(function(response) {
          me.categories = response.data.categories.data;
          me.pagination = response.data.pagination;
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    changePaging(page, option, keyword) {
      let me = this;

      me.pagination.current_page = page;

      me.listCategories(page, option, keyword);
    },
    validarCategory() {
      this.error = 0;
      this.errorMsgs = [];

      if (!this.name) this.errorMsgs.push("이름을 입려해주세요.");

      if (this.errorMsgs.length) this.error = 1;

      return this.error;
    },
    writeCategory() {
      if (this.validarCategory()) {
        return;
      }

      const me = this;

      axios
        .post("/categories", {
          name: this.name,
          description: this.description
        })
        .then(function(response) {
          me.closeModal();
          me.listCategories(1, "name", "");
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    updateCategory() {
      if (this.validarCategory()) {
        return;
      }

      const me = this;

      axios
        .put("/categories", {
          id: this.id,
          name: this.name,
          description: this.description
        })
        .then(function(response) {
          me.closeModal();
          me.listCategories(1, "name", "");
        })
        .catch(function(error) {
          console.log(error);
        });
    },
    desactivarCategory(id) {
      swal({
        title: "비활성화 하시겠습니까?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "비활성화",
        cancelButtonText: "취소",

        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,

        reverseButtons: true
      }).then(result => {
        if (result.value) {
          const me = this;

          axios
            .put("/categories/desactivar", {
              id: id
            })
            .then(function(response) {
              me.listCategories(1, "name", "");
              swal("비활성화", "상태가 비활성화 되었습니다.", "success");
            })
            .catch(function(error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
        }
      });
    },
    activarCategory(id) {
      swal({
        title: "활성화 하시겠습니까?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "활성화",
        cancelButtonText: "취소",

        confirmButtonClass: "btn btn-success",
        cancelButtonClass: "btn btn-danger",
        buttonsStyling: false,

        reverseButtons: true
      }).then(result => {
        if (result.value) {
          const me = this;

          axios
            .put("/categories/activar", {
              id: id
            })
            .then(function(response) {
              me.listCategories(1, "name", "");
              swal("활성화", "상태가 활성화 되었습니다.", "success");
            })
            .catch(function(error) {
              console.log(error);
            });
        } else if (
          // Read more about handling dismissals
          result.dismiss === swal.DismissReason.cancel
        ) {
        }
      });
    },
    openModal(model, action, data = {}) {
      switch (model) {
        case "category": {
          switch (action) {
            case "write": {
              this.id = "";
              this.name = "";
              this.description = "";
              this.modal = 1;
              this.modalTitle = "Category Write";
              this.defaultAction = 1;
              break;
            }
            case "update": {
              this.id = data.id;
              this.name = data.name;
              this.description = data.description;
              this.modal = 1;
              this.modalTitle = "Category update";
              this.defaultAction = 2;
              break;
            }
            case "delete": {
            }
          }
        }
      }
    },
    closeModal() {
      this.name = "";
      this.description = "";
      this.modal = 0;
      this.modalTitle = "";
    }
  },
  mounted() {
    this.listCategories(1, this.option, this.keyword);
  }
};
</script>

<style>
.modal-content {
  width: 100% !important;
  position: absolute !important;
}
.is_show {
  display: list-item !important;
  opacity: 1 !important;
  position: absolute !important;
  background-color: #3c29297a !important;
}
.div-error {
  display: flex;
  justify-content: center;
}
.text-error {
  color: red !important;
  font-weight: bold;
}
</style>