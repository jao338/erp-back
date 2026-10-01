```md
# Commit Message

Use as instruções gerais do projeto antes de gerar a mensagem.

#file:../copilot-instructions.md

## Objetivo

Analise as alterações atuais e gere uma mensagem de commit adequada às mudanças realmente realizadas.

## Padrão

Utilize Conventional Commits:

<type>(<scope>): <description>

Tipos permitidos:

- feat: nova funcionalidade;
- fix: correção de bug;
- refactor: alteração estrutural sem mudança de comportamento;
- perf: melhoria de performance;
- test: criação ou alteração de testes;
- docs: documentação;
- style: alterações de formatação ou estilo sem mudança de comportamento;
- build: alterações relacionadas a build ou dependências;
- ci: alterações relacionadas a CI/CD;
- chore: manutenção geral.

## Regras

1. Analise as alterações reais antes de criar a mensagem.
2. Não invente alterações.
3. Identifique o principal objetivo do conjunto de alterações.
4. Escolha o tipo mais adequado.
5. Utilize `scope` quando houver um escopo claro.
6. Escreva a descrição em português do Brasil.
7. Seja objetivo.
8. Utilize uma descrição curta e clara.
9. Não inclua detalhes irrelevantes.
10. Não descreva cada arquivo alterado individualmente.
11. Não use emojis.
12. Não coloque ponto final na descrição.

## Scope

Utilize um `scope` relacionado ao módulo, domínio ou contexto afetado.

Exemplos:

feat(auth): implementar recuperação de senha

fix(otp): corrigir validação de expiração

refactor(user): reorganizar validação do usuário

test(auth): adicionar testes de login

docs(api): atualizar documentação de autenticação

Se não houver um scope claro, omita-o:

chore: atualizar dependências

## Alterações Complexas

Quando uma alteração envolver múltiplos tipos de mudança, escolha o tipo correspondente ao objetivo principal.

Exemplo:

Se uma funcionalidade nova exigir uma refatoração interna:

feat(auth): implementar recuperação de senha

e não:

refactor(auth): refatorar autenticação

Se a alteração for exclusivamente estrutural e não mudar comportamento:

refactor(auth): reorganizar fluxo de autenticação

## Resultado

Retorne somente a mensagem de commit final.

Não explique a escolha.

Não utilize Markdown.

Exemplo:

feat(auth): implementar recuperação de senha
