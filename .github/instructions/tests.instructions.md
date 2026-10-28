# Instruções para criação dos testes do backend ERP

## 1. Objetivo

Criar uma suíte de testes automatizados para o backend do ERP, usando os testes existentes em `tests/Feature/ExampleTest.php` e `tests/Unit/ExampleTest.php` como referência inicial de convenções do projeto.

O foco deste trabalho é:

- testar as rotas da API por meio de testes de **Feature**;
- testar integrações reais entre componentes do sistema por meio de testes de **Integration**;
- buscar cobertura significativa de todos os endpoints;
- verificar autenticação, autorização, validação, persistência, respostas HTTP e regras de negócio;
- impedir que os testes dependam de dados reais ou alterem bancos de desenvolvimento, homologação ou produção.

A meta de cobertura de rotas não deve ser confundida com 100% de cobertura de linhas, funções ou branches. São métricas diferentes e devem ser acompanhadas separadamente.

## 2. Regras obrigatórias

1. **Use `ExampleTest` como referência.** Antes de criar um arquivo, leia o `ExampleTest` correspondente e mantenha o estilo, os métodos de asserção e as convenções já adotadas no projeto, adaptando apenas o necessário ao cenário testado.
2. **Organize os testes conforme os domínios e módulos existentes no backend.** Não agrupe todos os testes em um único arquivo nem crie pastas sem relação com a estrutura atual do projeto.
3. **Escreva os nomes dos métodos de teste em inglês, por extenso, em `snake_case`, separados por `_`.** O nome deve descrever o comportamento esperado, não apenas o nome da funcionalidade.
4. Use os métodos de teste públicos que o PHPUnit reconhece, com o prefixo `test_`, por exemplo: `test_guest_cannot_list_products`.
5. Cada teste deve verificar um comportamento principal claro. Evite testes grandes que cubram vários cenários independentes.
6. Teste o comportamento observável do sistema, evitando acoplar o teste a detalhes internos de implementação quando isso não for necessário.
7. Use dados e dependências de teste isolados. Nunca execute testes contra um banco real de CRM, homologação ou produção.
8. Não introduza `isBaseCRM` nem verificações equivalentes para decidir silenciosamente se os testes devem ser ignorados. A remoção de `isBaseCRM` já foi feita no projeto.
9. Não use `skip` para esconder falhas de configuração ou indisponibilidade de dependências necessárias. Se o ambiente obrigatório não estiver configurado, corrija a configuração ou faça o teste falhar de maneira explícita.
10. Não invente factories, campos, rotas, Actions ou contratos de resposta. Confira o código atual antes de escrever o teste e use os nomes e comportamentos reais do projeto.

## 3. Estrutura de arquivos

Antes de criar pastas, confira a estrutura atual de `tests/` e os módulos existentes em `domain/` e `routes/`. Preserve as convenções do repositório sempre que possível.

Estrutura de referência sugerida:

```text
tests/
├── Feature/
│   ├── Auth/
│   │   ├── LoginTest.php
│   │   ├── RegisterTest.php
│   │   ├── FirstAccessTest.php
│   │   ├── VerifyCodeAccessTest.php
│   │   ├── AuthenticatedUserTest.php
│   │   └── LogoutTest.php
│   ├── Product/
│   │   ├── ProductIndexTest.php
│   │   ├── ProductShowTest.php
│   │   ├── ProductStoreTest.php
│   │   ├── ProductUpdateTest.php
│   │   └── ProductDestroyTest.php
│   ├── Supplier/
│   ├── Client/
│   ├── Shopping/
│   ├── Sale/
│   └── Lookup/
├── Integration/
│   ├── Auth/
│   ├── Product/
│   ├── Shopping/
│   └── Sale/
├── Unit/
│   └── ...
└── TestCase.php
```

Essa árvore é uma referência, não uma ordem para criar todos os arquivos de uma vez. Crie arquivos somente quando houver um comportamento real a testar. Se o projeto já tiver uma convenção diferente, mantenha a convenção existente e organize por domínio.

### Feature

Use `tests/Feature/` para testar a API de ponta a ponta no nível HTTP, incluindo rota, middleware, autenticação, validação, controller, Actions, banco de dados e formato da resposta, conforme o cenário.

### Integration

Use `tests/Integration/` para verificar a colaboração entre componentes concretos, como uma Action com o banco de dados, uma operação transacional, geração e persistência de dados, ou integração com fila/e-mail quando esse comportamento fizer parte do contrato do sistema.

Um teste de integração não precisa chamar uma rota HTTP. Se o cenário testa a resposta HTTP e o fluxo da API, prefira `Feature`. Evite duplicar o mesmo cenário nas duas suítes sem uma razão clara.

### Unit

O escopo solicitado é Feature e Integration. Mantenha os testes unitários já existentes, mas não crie testes unitários como substitutos dos testes HTTP ou de integração necessários.

## 4. Convenção para nomes dos testes

Os métodos devem usar inglês, `snake_case`, prefixo `test_` e uma descrição explícita do comportamento esperado.

**Bons exemplos:**

```php
public function test_guest_cannot_list_products(): void
public function test_authenticated_user_can_view_a_product(): void
public function test_product_creation_fails_when_required_fields_are_missing(): void
public function test_product_update_returns_not_found_when_product_does_not_exist(): void
public function test_cancelled_shopping_does_not_change_stock(): void
public function test_sale_creation_rolls_back_when_stock_is_insufficient(): void
```

**Evite nomes vagos ou abreviados:**

```php
public function test_product(): void
public function test_store(): void
public function test_error(): void
public function test_product_422(): void
```

O nome deve deixar claro o cenário e o resultado esperado sem exigir que alguém leia o corpo do teste para entender sua intenção.

Para nomes de classes, mantenha o padrão PHPUnit do projeto, normalmente em `PascalCase` e terminando em `Test`, por exemplo `ProductStoreTest.php`.

## 5. Usar `ExampleTest` como base

Antes de implementar testes novos:

1. Leia `tests/Feature/ExampleTest.php` e `tests/Unit/ExampleTest.php`.
2. Confira `tests/TestCase.php`, `phpunit.xml` e a configuração de ambiente de teste.
3. Preserve a herança de `Tests\TestCase` e o estilo de organização já utilizado.
4. Reaproveite helpers, factories e métodos de preparação existentes quando eles forem adequados ao cenário.
5. Não copie cegamente o teste de exemplo: substitua a rota, os dados e as asserções pelo comportamento real que precisa ser validado.

Exemplo mínimo de teste Feature, a adaptar após confirmar a rota e o contrato reais:

```php
<?php

namespace Tests\Feature\Product;

use Tests\TestCase;

class ProductIndexTest extends TestCase
{
    public function test_guest_cannot_list_products(): void
    {
        $response = $this->getJson('/api/products');

        $response->assertUnauthorized();
    }
}
```

Esse exemplo só é correto se a rota `/api/products` exigir autenticação e responder com `401` para visitantes. Confirme esse comportamento nas rotas e middlewares atuais antes de usá-lo.

## 6. O que testar em Feature

Para cada endpoint, identifique os cenários aplicáveis abaixo. Não force todos os cenários em todas as rotas: escolha os que fazem sentido para o contrato real.

### 6.1 Acesso e autenticação

- visitante recebe `401` nas rotas protegidas;
- usuário autenticado consegue acessar os recursos permitidos;
- usuário sem permissão recebe o status previsto pelo contrato (`403`, `404` ou outro comportamento documentado);
- login aceita credenciais válidas e rejeita credenciais inválidas;
- logout invalida a sessão ou credencial de acordo com o mecanismo utilizado;
- endpoints de primeiro acesso e verificação de código cobrem sucesso, código inválido/expirado e limite de tentativas, conforme a implementação.

### 6.2 Validação

- dados válidos são aceitos;
- campos obrigatórios ausentes são rejeitados;
- formatos ou tipos inválidos são rejeitados;
- valores fora dos limites aceitos são rejeitados;
- referências a registros inexistentes são rejeitadas;
- erros de validação retornam a estrutura JSON e o status esperados, normalmente `422` quando esse é o contrato da API.

### 6.3 Leitura e listagem

- listagem retorna o status e a estrutura JSON esperados;
- detalhes retornam o registro correto;
- registros inexistentes retornam o status definido pela API;
- filtros, ordenação e paginação são testados se forem funcionalidades expostas;
- dados sensíveis ou campos internos não são expostos indevidamente.

### 6.4 Criação, atualização e exclusão

- criação válida persiste os dados esperados;
- atualização válida altera somente os campos permitidos;
- exclusão segue a regra real do sistema, incluindo exclusão lógica quando aplicável;
- payload inválido não cria nem altera registros;
- usuário não autorizado não consegue modificar registros;
- respostas HTTP e payloads correspondem ao contrato da rota.

### 6.5 Regras de negócio

Nos módulos de compras e vendas, teste as regras que realmente existirem na implementação, por exemplo:

- não permitir quantidades ou valores inválidos;
- impedir operações com estoque insuficiente, caso essa regra faça parte do fluxo;
- verificar os efeitos da confirmação, cancelamento ou exclusão sobre estoque e situação do documento;
- garantir que uma operação inválida não deixe alterações parciais;
- impedir transições de estado não permitidas;
- validar o relacionamento correto entre cabeçalho, itens e entidades relacionadas.

Não presuma que essas regras já estão implementadas. Use os requisitos, as rotas, as Actions e o código atual para determinar os comportamentos esperados.

## 7. O que testar em Integration

Testes de integração devem exercitar componentes reais em conjunto, usando dependências de teste isoladas.

Priorize cenários como:

- uma Action grava no banco os registros e relacionamentos esperados;
- uma transação persiste todas as alterações quando a operação termina com sucesso;
- uma falha durante uma operação transacional provoca rollback e não deixa dados parciais;
- operações de compra/venda mantêm consistência entre documento, itens, estoque e status, conforme as regras implementadas;
- envio de e-mail, notificações ou jobs é disparado com os dados esperados quando fizer parte do fluxo;
- o fluxo de OTP gera, armazena e valida o código de acordo com as regras implementadas;
- componentes que dependem de banco, fila ou cache colaboram corretamente.

Use fakes ou mocks quando o objetivo for verificar a interação com um serviço externo sem executá-lo de verdade. Use o componente real quando a integração em si estiver sendo testada. Deixe essa escolha explícita no teste.

Não dependa de serviços externos reais, caixas de e-mail reais ou filas de produção durante a suíte automatizada.

## 8. Isolamento do ambiente e banco de dados

A suíte deve rodar em ambiente de teste dedicado. Configure `.env.testing` ou o mecanismo de configuração de teste já adotado pelo projeto, com credenciais e banco exclusivos para testes.

Requisitos:

- nunca apontar o ambiente de teste para o banco de produção ou para um banco real de CRM;
- conferir `phpunit.xml` para entender quais variáveis de ambiente são sobrescritas durante a execução;
- escolher conscientemente a estratégia de isolamento dos dados, como transações por teste ou recriação/migração do schema, conforme o comportamento da suíte;
- evitar misturar estratégias incompatíveis de transação e `RefreshDatabase` sem entender o efeito no teste;
- garantir que cada teste possa ser executado sozinho e que a ordem dos testes não altere os resultados;
- criar dados necessários explicitamente com factories ou helpers existentes;
- não depender de dados previamente inseridos manualmente no banco.

Como `isBaseCRM` foi removido, não reintroduza essa verificação. A proteção contra uso do banco errado deve vir de uma configuração de teste isolada e explícita, e não de um mecanismo que silencie ou pule testes.

## 9. Fakes, mocks e efeitos colaterais

- Use `Mail::fake()`, `Queue::fake()`, `Notification::fake()` ou equivalentes nos testes que precisarem verificar esses efeitos sem executá-los.
- Prefira configurar os fakes no teste específico que precisa deles, salvo se o `TestCase` do projeto estabelecer deliberadamente uma convenção global bem documentada.
- Quando usar um fake, verifique que a mensagem, job ou notificação esperada foi disparada e, quando relevante, confira os dados enviados.
- Não use mocks para tudo: um teste de integração deve exercitar a colaboração real entre os componentes que são o objeto do teste.
- Limpe ou isole qualquer estado compartilhado entre testes.

## 10. Cobertura de rotas

Monte e mantenha uma matriz baseada nas rotas realmente registradas pelo Laravel. Não use apenas uma lista escrita manualmente sem conferi-la com `routes/api.php`, arquivos de rotas adicionais e middleware.

Para cada rota, registre:

| Campo | O que registrar |
|---|---|
| Método e caminho | Método HTTP e URI exatos |
| Nome/ação | Nome da rota ou controller/action responsável |
| Autenticação | Pública ou protegida |
| Cenário de sucesso | Comportamento principal esperado |
| Cenários de falha | Validação, ausência de registro, permissão ou regra de negócio aplicável |
| Arquivo de teste | Arquivo responsável por cobrir o comportamento |
| Status | Pendente, implementado ou revisado |

O objetivo inicial é ter pelo menos um teste de comportamento significativo para cada endpoint, além dos testes de falha relevantes. Um endpoint não está adequadamente testado só porque foi chamado: as asserções devem verificar o resultado esperado.

Considere separadamente:

- **cobertura de rotas:** endpoints e métodos HTTP exercitados;
- **cobertura de linhas:** linhas de código executadas;
- **cobertura de branches:** caminhos condicionais exercitados;
- **cobertura de regras de negócio:** invariantes e resultados críticos verificados.

Confira a configuração de cobertura em `phpunit.xml`. Se o escopo incluir somente `domain/`, o relatório não representa automaticamente todo o código do backend fora desse diretório. Ajuste o escopo de forma intencional antes de declarar uma meta global de cobertura.

## 11. Ordem recomendada de implementação

Implemente os testes incrementalmente, mantendo a suíte executável após cada etapa:

1. **Preparar o ambiente de teste:** conferir `phpunit.xml`, `tests/TestCase.php`, `.env.testing` e o isolamento do banco.
2. **Autenticação:** login, registro, primeiro acesso, verificação de código, usuário autenticado e logout.
3. **Produtos:** listagem, detalhes, criação, atualização e exclusão.
4. **Clientes, fornecedores e lookups:** leitura, autenticação e comportamento para registros inexistentes, quando aplicável.
5. **Compras:** criação, consulta, cancelamento/exclusão e consistência de dados, de acordo com as rotas reais.
6. **Vendas:** criação, consulta, cancelamento/exclusão e regras de estoque/estado que estejam implementadas.
7. **Integrações críticas:** transações, rollback, banco de dados, filas, e-mails e notificações.
8. **Revisão de cobertura:** identificar endpoints sem teste, cenários de falha ausentes e branches importantes não exercitados.
9. **Automação:** garantir que a suíte rode de forma previsível no ambiente local e, posteriormente, no CI.

A ordem pode ser ajustada se as dependências reais do código exigirem outra sequência.

## 12. Critérios de conclusão por teste

Considere um teste pronto quando:

- [ ] o nome em inglês descreve o comportamento esperado e usa `snake_case`;
- [ ] a classe está na pasta adequada ao domínio e ao tipo de teste;
- [ ] o teste segue as convenções de `ExampleTest` e `Tests\TestCase`;
- [ ] os dados necessários são preparados pelo próprio teste;
- [ ] o resultado é verificado com asserções úteis, incluindo status e payload quando aplicável;
- [ ] efeitos no banco são verificados quando o cenário exige persistência;
- [ ] falhas não deixam dados parciais quando há transação envolvida;
- [ ] o teste não depende de ordem de execução nem de dados manuais;
- [ ] o teste não usa banco ou serviço externo real;
- [ ] o teste passa isoladamente e junto com a suíte.

## 13. Comandos úteis

Execute os comandos na versão e no ambiente configurados pelo projeto:

```bash
# Executar toda a suíte
php artisan test

# Executar somente Feature
php artisan test tests/Feature

# Executar somente Integration
php artisan test tests/Integration

# Executar um arquivo específico
php artisan test tests/Feature/Product/ProductIndexTest.php

# Executar um método específico
php artisan test --filter=test_guest_cannot_list_products

# Ver as rotas registradas e seus middlewares
php artisan route:list --path=api
```

Para cobertura, confirme primeiro se Xdebug ou PCOV e a configuração de cobertura do PHPUnit estão disponíveis. Depois, use o comando compatível com a configuração instalada, por exemplo:

```bash
php artisan test --coverage
```

Se a opção não estiver configurada, resolva a configuração de cobertura em vez de interpretar a ausência de relatório como cobertura total.

## 14. Orientação final para quem implementar

Antes de criar cada teste, inspecione a rota, o middleware, o controller, as Actions chamadas, as validações, os models/relacionamentos e os requisitos pertinentes. Escreva o teste a partir do comportamento real e esperado do sistema, não a partir de suposições.

Priorize testes legíveis, determinísticos e úteis para detectar regressões. A meta não é maximizar a quantidade de métodos de teste, mas cobrir cada endpoint e as regras importantes com cenários que realmente falhariam se o sistema estivesse incorreto.
