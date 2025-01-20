var crud = angular.module("crud", []);

crud.controller("controller", function ($scope) {

    $scope.novoCliente = {};
    $scope.clienteSelecionado = {};
    $scope.novoContato = {}; // Para armazenar os dados do novo contato
    $scope.mostrarNovoContato = false; // Controla a exibição dos campos do novo contato

    $scope.clientes = [
        
    ];

    
    $scope.idCounter = 1; 

    // Paginação
    $scope.currentPage = 1;
    $scope.itemsPerPage = 7;

    $scope.salvar = function () {
        
        $scope.novoCliente.id = $scope.idCounter++;
        
        // Verifica se o nome não está vazio antes de concatenar o tipo
        if ($scope.novoCliente.nome) {
            if ($scope.novoCliente.tipo === "fisica") {
                $scope.novoCliente.nome += " (Físico)";
            } else if ($scope.novoCliente.tipo === "juridica") {
                $scope.novoCliente.nome += " (Jurídico)";
            }
        }

        $scope.clientes.push(angular.copy($scope.novoCliente)); // Usa angular.copy para evitar referência
        $scope.novoCliente = {}; // Limpa o novo cliente
        $scope.updatePagination(); // Atualiza a paginação após adicionar um novo cliente
    };
    
    $scope.selecionaCliente = function (cliente) {
        $scope.clienteSelecionado = angular.copy(cliente); // Copia o cliente selecionado
        $scope.novoContato = {}; // Limpa o novo contato ao selecionar um cliente
        $scope.mostrarNovoContato = false; // Reseta a exibição dos campos do novo contato
    };

    $scope.alterarCliente = function () {
        // Encontre o índice do cliente selecionado na lista de clientes
        var index = $scope.clientes.findIndex(c => c.id === $scope.clienteSelecionado.id);
        if (index !== -1) {
            // Atualiza o cliente selecionado na lista de clientes
            $scope.clientes[index] = angular.copy($scope.clienteSelecionado);
        } else {
            console.error("Cliente não encontrado na lista.");
        }
    };

    $scope.excluirCliente = function() {
        $scope.clientes.splice($scope.clientes.indexOf($scope.clienteSelecionado), 1);
        $scope.clienteSelecionado = {}; // Limpa a seleção após a exclusão
        $scope.updatePagination(); // Atualiza a paginação após excluir um cliente
    };

    $scope.adicionarContato = function() {
        // Limpa os campos do novo contato
        $scope.novoContato = {};
        $scope.mostrarNovoContato = true; // Mostra os campos do novo contato
    };

    $scope.salvarNovoContato = function() {
        if ($scope.novoContato.nome && $scope.novoContato.valor && $scope.novoContato.tipo) {
            // Adiciona o novo contato à lista de contatos do cliente selecionado
            if (!$scope.clienteSelecionado.contatos) {
                $scope.clienteSelecionado.contatos = []; // Inicializa a lista de contatos se não existir
            }
            $scope.clienteSelecionado.contatos.push(angular.copy($scope.novoContato));
            // Limpa os campos do novo contato
            $scope.novoContato = {};
            $scope.mostrarNovoContato = false; // Oculta os campos após salvar
        } else {
            alert("Por favor, preencha todos os campos do novo contato.");
        }
    };

    // Funções de Edição e Exclusão de Contatos
    $scope.editarContato = function(contato) {
        
        $scope.novoContato = angular.copy(contato);
        $scope.mostrarNovoContato = true; 
    };

    $scope.excluirContato = function(contato) {
        var index = $scope.clienteSelecionado.contatos.indexOf(contato);
        if (index !== -1) {
            $scope.clienteSelecionado.contatos.splice(index, 1); 
        }
    };

    
    $scope.updatePagination = function() {
     $scope.totalPages = Math.ceil($scope.clientes.length / $scope.itemsPerPage);
 };

 $scope.setPage = function(page) {
     if (page < 1 || page > $scope.totalPages) return;
     $scope.currentPage = page;
 };

 $scope.getDisplayedClients = function() {
     var start = ($scope.currentPage - 1) * $scope.itemsPerPage;
     return $scope.clientes.slice(start, start + $scope.itemsPerPage);
 };


 $scope.updatePagination();
});