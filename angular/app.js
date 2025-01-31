var crud = angular.module("crud", []);

crud.controller("controller", function ($scope) {
    $scope.novoCliente = {};
    $scope.clienteSelecionado = {};
    $scope.novoContato = {}; 
    $scope.mostrarNovoContato = false;

    $scope.clientes = [];
    $scope.idCounter = 1; 

    // Inicializa com um cliente de exemplo
    $scope.clientes.push({ id: $scope.idCounter++, nome: "Vigor Hugo", tipo: "fisica", contatos: [] });

    // Paginação
    $scope.currentPage = 1;
    $scope.itemsPerPage = 7;

    // Função para salvar um novo cliente
    $scope.salvarNovoCliente = function () {
        if ($scope.novoCliente.nome && $scope.novoCliente.tipo) {
            var clienteComId = angular.copy($scope.novoCliente);
            clienteComId.id = $scope.idCounter++; // Atribui um novo ID
            clienteComId.contatos = []; // Inicializa contatos como um array vazio
            $scope.clientes.push(clienteComId);
            $scope.novoCliente = {}; // Limpa o novo cliente
            $scope.updatePagination();

            // Muda para a última página se o número de clientes exceder o limite
            if ($scope.clientes.length > $scope.itemsPerPage * $scope.currentPage) {
                $scope.currentPage = Math.ceil($scope.clientes.length / $scope.itemsPerPage);
            }

            $('#myModal').modal('hide'); // Fecha o modal
        } else {
            alert("Por favor, preencha todos os campos obrigatórios.");
        }
    };

    // Função para selecionar um cliente
    $scope.selecionaCliente = function (cliente) {
        $scope.clienteSelecionado = angular.copy(cliente); // Copia o cliente selecionado
        $scope.mostrarNovoContato = false; // Reseta a exibição dos campos do novo contato
    };

    // Função para alterar um cliente
    $scope.alterarCliente = function () {
        if (!$scope.clienteSelecionado.id) {
            alert("Nenhum cliente selecionado ou ID inválido.");
            return;
        }
    
        var index = $scope.clientes.findIndex(c => c.id === $scope.clienteSelecionado.id);
        if (index !== -1) {
            $scope.clientes[index] = angular.copy($scope.clienteSelecionado);
            $('#myModalEditar').modal('hide'); // Fecha o modal de edição
        } else {
            console.error("Cliente não encontrado na lista.");
        }
    };

    // Função para excluir um cliente
    $scope.excluirCliente = function() {
        if (!$scope.clienteSelecionado.id) {
            alert("Nenhum cliente selecionado para exclusão.");
            return;
        }
    
        var index = $scope.clientes.findIndex(c => c.id === $scope.clienteSelecionado.id);
        if (index !== -1) {
            $scope.clientes.splice(index, 1); // Remove o cliente da lista
            $scope.clienteSelecionado = {}; // Limpa a seleção
            $scope.updatePagination(); 
            alert("Cliente excluído com sucesso!"); 
        } else {
            console.error("Erro: Cliente não encontrado.");
        }
    };

    // Função para adicionar um novo contato
    $scope.salvarNovoContato = function() {
        if ($scope.novoContato.nome && $scope.novoContato.valor && $scope.novoContato.tipo) {
            // Adiciona o novo contato ao cliente selecionado
            if (!$scope.clienteSelecionado.contatos) {
                $scope.clienteSelecionado.contatos = []; // Inicializa contatos se não existir
            }
            $scope.clienteSelecionado.contatos.push(angular.copy($scope.novoContato));
            $scope.novoContato = {}; // Limpa o novo contato
            $scope.mostrarNovoContato = false; // Oculta o formulário de novo contato
            alert("Contato adicionado com sucesso!");
        } else {
            alert("Por favor, preencha todos os campos obrigatórios.");
        }
    };

    // Função para excluir um contato
    $scope.excluirContato = function(contato) {
        var index = $scope.clienteSelecionado.contatos.indexOf(contato);
        if (index !== -1) {
            $scope.clienteSelecionado.contatos.splice(index, 1); // Remove o contato da lista
            alert("Contato excluído com sucesso!"); 
        } else {
            console.error("Contato não encontrado na lista.");
        }
    };

    // Função para editar um contato
    $scope.editarContato = function(contato) {
        $scope.novoContato = angular.copy(contato);
        $scope.mostrarNovoContato = true; 
    };
    
    // Função para atualizar a paginação
    $scope.updatePagination = function() {
        $scope.totalPages = Math.ceil($scope.clientes.length / $scope.itemsPerPage);
    };
    
    // Função para definir a página atual
    $scope.setPage = function(page) {
        if (page < 1 || page > $scope.totalPages) return;
        $scope.currentPage = page;
    };
    
    // Função para obter os clientes a serem exibidos na página atual
    $scope.getDisplayedClients = function() {
        var start = ($scope.currentPage - 1) * $scope.itemsPerPage;
        var displayedClients = $scope.clientes.slice(start, start + $scope.itemsPerPage);
        return displayedClients;
    };
    
    // Inicializa a paginação
    $scope.updatePagination();
});