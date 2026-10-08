---
applyTo: "**"
---

# Instruções para Code Review

## Objetivo

Faça uma revisão técnica das alterações realizadas no projeto.

Priorize a identificação de problemas reais ou potenciais relacionados a:

1. Bugs;
2. problemas de segurança;
3. problemas de lógica;
4. regressões;
5. problemas de arquitetura;
6. problemas de performance;
7. problemas de concorrência;
8. problemas de validação;
9. problemas de tratamento de erros;
10. problemas de testes;
11. problemas de manutenção;
12. inconsistências com os padrões existentes do projeto.

## Antes da Revisão

Antes de apontar problemas:

1. Analise as alterações realizadas.
2. Entenda o contexto do código alterado.
3. Consulte implementações relacionadas quando necessário.
4. Identifique os padrões utilizados pelo projeto.
5. Verifique se a alteração está consistente com o módulo afetado.
6. Considere o comportamento anterior quando necessário.

Não avalie uma alteração isoladamente quando o contexto do projeto for necessário para determinar se ela está correta.

## Arquitetura

Verifique se as alterações:

- seguem o padrão arquitetural existente;
- respeitam a separação de responsabilidades;
- reutilizam estruturas existentes quando apropriado;
- introduzem abstrações desnecessárias;
- criam duplicação;
- misturam responsabilidades;
- utilizam Actions, Services, Repositories, DTOs ou outras estruturas de acordo com o padrão real do projeto.

Não considere uma arquitetura diferente como errada apenas porque existe outra preferência arquitetural.

Se houver diferentes padrões no projeto, considere o padrão utilizado pelo módulo ou contexto analisado.

## Segurança

Verifique especialmente:

- autenticação;
- autorização;
- validação;
- exposição de dados;
- SQL injection;
- XSS;
- CSRF;
- manipulação de arquivos;
- dados sensíveis;
- permissões;
- logs;
- tratamento de exceções;
- problemas de concorrência.

## Banco de Dados

Verifique:

- N+1 queries;
- consultas desnecessárias;
- filtros incorretos;
- índices;
- transações;
- integridade dos dados;
- concorrência;
- grandes volumes de dados;
- possíveis problemas de performance.

## Performance

Verifique:

- processamento desnecessário;
- chamadas repetidas;
- consultas excessivas;
- carregamento desnecessário de dados;
- operações síncronas que poderiam impactar o fluxo;
- utilização inadequada de cache;
- processamento que deveria utilizar filas, quando isso estiver de acordo com o padrão do projeto.

Não sugira otimizações sem benefício concreto.

## Testes

Verifique:

- se o comportamento alterado possui cobertura adequada;
- se os testes existentes continuam válidos;
- se existem cenários importantes não cobertos;
- se os testes realmente validam o comportamento esperado;
- se novos caminhos de execução relevantes ficaram sem cobertura.

## Prioridade

Classifique os problemas encontrados conforme sua severidade.

### CRITICAL

Problemas que podem causar:

- vulnerabilidade de segurança significativa;
- perda ou corrupção de dados;
- falha crítica da aplicação;
- comportamento crítico incorreto.

### HIGH

Problemas que podem causar:

- bugs relevantes;
- regressões;
- falhas em cenários importantes;
- problemas significativos de performance;
- violações importantes de regras de negócio.

### MEDIUM

Problemas que podem:

- gerar comportamento incorreto em casos específicos;
- dificultar significativamente a manutenção;
- gerar problemas moderados de performance;
- aumentar desnecessariamente a complexidade.

### LOW

Problemas menores que:

- dificultem levemente a manutenção;
- apresentem inconsistências de baixo impacto;
- possam ser melhorados sem urgência.

Não aumente artificialmente a severidade de um problema.

## Resultado

Apresente primeiro um resumo objetivo da revisão.

Depois, liste somente os problemas que realmente merecem atenção.

Para cada problema, informe:

- prioridade;
- arquivo;
- localização aproximada;
- problema;
- motivo;
- sugestão de correção.

Utilize o seguinte formato:

[HIGH] app/Example/File.php:42

Problema:
Descrição objetiva do problema.

Motivo:
Explique por que isso pode causar um problema.

Sugestão:
Explique uma possível abordagem para corrigir o problema.

## O que NÃO fazer

Não:

- invente problemas;
- critique código apenas por preferência pessoal;
- sugira refatorações sem benefício concreto;
- peça mudanças puramente cosméticas;
- reescreva partes não relacionadas;
- considere uma implementação errada apenas por utilizar outro padrão arquitetural;
- aumente artificialmente a severidade;
- repita o mesmo problema em vários lugares.

## Ausência de Problemas

Se não forem encontrados problemas relevantes, informe claramente que a revisão não encontrou problemas significativos.

Não invente sugestões apenas para produzir uma lista de observações.

## Regra Principal

Priorize problemas reais sobre sugestões de estilo.

Uma revisão útil deve encontrar problemas que um desenvolvedor deveria conhecer antes de aprovar as alterações.
