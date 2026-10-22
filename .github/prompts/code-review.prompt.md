# Code Review

Use as instruções gerais do projeto e as instruções específicas de Code Review antes de realizar esta revisão.

#file:../copilot-instructions.md
#file:../instructions/code-review.instructions.md

## Objetivo

Faça uma revisão técnica das alterações atuais.

Analise primeiro:

- as alterações realizadas;
- o contexto dos arquivos modificados;
- implementações relacionadas;
- os padrões existentes no projeto;
- possíveis impactos em outras partes do sistema.

## Prioridades

Priorize nesta ordem:

1. Bugs e erros de lógica;
2. segurança;
3. regressões;
4. regras de negócio;
5. problemas de arquitetura;
6. problemas de concorrência;
7. problemas de performance;
8. problemas de validação;
9. tratamento de erros;
10. testes;
11. manutenção.

## Critério

Não considere como problema algo que seja apenas:

- preferência pessoal;
- diferença de estilo;
- escolha arquitetural válida;
- possibilidade teórica sem impacto relevante.

Não invente problemas.

Não sugira refatorações que não tragam benefício concreto.

## Contexto

Considere o código existente antes de propor mudanças.

Se o projeto já utiliza determinada abordagem, avalie a alteração de acordo com essa abordagem.

Não imponha Actions, Services, Repositories, DTOs ou qualquer outro padrão sem verificar primeiro como o projeto resolve problemas semelhantes.

## Formato da Revisão

Apresente:

### Resumo

Resumo objetivo do estado das alterações.

### Problemas encontrados

Para cada problema:

```text
[PRIORIDADE] arquivo:linha

Problema:
...

Motivo:
...

Sugestão:
...
