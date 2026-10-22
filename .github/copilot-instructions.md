# Instruções Gerais do Projeto

## Idioma

- Responda sempre em português do Brasil.
- Explique decisões técnicas, análises, sugestões e justificativas em português do Brasil.
- Mantenha em inglês os elementos que fazem parte do código, como:
    - nomes de classes;
    - métodos;
    - funções;
    - variáveis;
    - propriedades;
    - interfaces;
    - enums;
    - constantes;
    - nomes de arquivos;
    - endpoints, quando seguirem o padrão existente.
- Não traduza identificadores existentes do projeto apenas para adequá-los ao português.

## Conhecimento do Projeto

Antes de propor ou realizar alterações:

1. Analise a estrutura existente do projeto.
2. Identifique os padrões já utilizados.
3. Procure implementações semelhantes antes de criar novas.
4. Reutilize estruturas existentes quando fizer sentido.
5. Evite introduzir padrões diferentes dos já adotados pelo projeto sem justificativa técnica.
6. Considere as dependências, versões e tecnologias efetivamente utilizadas pelo projeto.

## Padrões de Código

- Siga o padrão de nomenclatura já utilizado no projeto.
- Mantenha consistência com classes, métodos, funções, variáveis e arquivos existentes.
- Priorize código legível, previsível e de fácil manutenção.
- Evite abstrações desnecessárias.
- Evite duplicação de código quando uma reutilização simples e clara for possível.
- Não faça refatorações não relacionadas à tarefa solicitada.
- Não altere código existente apenas por preferência pessoal ou estética.
- Preserve o comportamento existente quando a tarefa não exigir sua alteração.
- Prefira tipagem forte quando a linguagem e o projeto permitirem.
- Evite `any`, `mixed` ou equivalentes quando houver uma alternativa adequada e compatível com o projeto.

## Arquitetura

- Não presuma que o projeto utiliza uma arquitetura específica.
- Antes de criar ou modificar uma implementação, identifique como o projeto organiza responsabilidades.
- Se o projeto utiliza Actions, Services, Repositories ou outras camadas, siga o padrão existente.
- Se houver mais de um padrão no projeto, siga o padrão utilizado pelo módulo ou contexto que está sendo alterado.
- Não introduza Services, Repositories, Actions, Helpers, DTOs ou outras abstrações sem necessidade.
- Não substitua uma arquitetura existente por outra sem justificativa técnica clara.
- Respeite a separação de responsabilidades já estabelecida pelo projeto.
- A consistência com o projeto existente tem prioridade sobre preferências arquiteturais genéricas.

## Alterações

Antes de modificar arquivos:

1. Entenda o fluxo atual.
2. Identifique os arquivos diretamente envolvidos.
3. Verifique dependências e usos da funcionalidade.
4. Avalie possíveis efeitos colaterais.
5. Faça a menor alteração necessária para atender ao objetivo.

Quando uma alteração puder afetar outras partes do sistema, informe quais partes podem ser impactadas.

## Segurança

Considere sempre:

- autenticação;
- autorização;
- validação de entrada;
- exposição indevida de dados;
- SQL injection;
- XSS;
- CSRF;
- controle de acesso;
- manipulação insegura de arquivos;
- dados sensíveis;
- tratamento de erros;
- logs contendo informações sensíveis;
- problemas de concorrência.

Não introduza mecanismos de segurança desnecessários, mas não ignore riscos relevantes.

## Banco de Dados

Ao trabalhar com banco de dados:

- Considere o padrão utilizado pelo projeto.
- Evite consultas desnecessárias.
- Observe possíveis problemas de N+1.
- Avalie índices quando apropriado.
- Considere transações quando múltiplas operações precisarem ser atômicas.
- Não altere migrations existentes sem avaliar o impacto.
- Preserve a compatibilidade com o banco utilizado pelo projeto.

## Performance

Considere:

- quantidade de consultas;
- N+1 queries;
- processamento desnecessário;
- loops sobre grandes volumes;
- carregamento desnecessário de dados;
- cache;
- filas;
- processamento síncrono versus assíncrono;
- impacto das alterações no frontend e backend.

Não faça otimizações prematuras sem evidência ou necessidade.

## Testes

Ao alterar comportamento:

- Procure testes existentes relacionados à funcionalidade.
- Mantenha os testes existentes funcionando.
- Adicione ou atualize testes quando apropriado.
- Priorize testes que validem comportamento e regras de negócio.
- Não altere testes apenas para fazê-los passar sem entender a causa da falha.

## Erros e Exceções

- Siga o padrão de tratamento de exceções existente.
- Não capture exceções sem necessidade.
- Não silencie erros.
- Não exponha informações internas ou sensíveis nas respostas da aplicação.
- Preserve mensagens e códigos de erro existentes quando não houver necessidade de alterá-los.

## Dependências

Antes de adicionar uma nova dependência:

1. Verifique se o projeto já possui uma solução equivalente.
2. Avalie se a dependência é realmente necessária.
3. Considere manutenção, compatibilidade e impacto no projeto.
4. Não adicione dependências apenas para resolver problemas simples que podem ser tratados pela stack existente.

## Comunicação

Ao explicar uma implementação:

1. Seja direto.
2. Explique o motivo das decisões importantes.
3. Aponte riscos ou impactos relevantes.
4. Diferencie fatos, suposições e sugestões.
5. Não apresente uma preferência pessoal como se fosse uma regra do projeto.

Quando houver dúvida sobre a intenção ou arquitetura, analise primeiro o código existente antes de assumir uma solução.

## Regra Principal

O código existente é a principal referência para determinar os padrões do projeto.

Antes de criar algo novo, procure como problemas semelhantes já são resolvidos.

Consistência com o projeto existente é mais importante do que aplicar uma preferência arquitetural genérica.
