document.addEventListener('DOMContentLoaded', function() {
    const copyButton = document.getElementById('CFCG_copy_button');
    const noRadio = document.getElementById('CFCG_no_radio');
    const titleRadio = document.getElementById('CFCG_title_radio');
    const summaryRadio = document.getElementById('CFCG_summary_radio');
    const postContentText = document.getElementById('CFCG_post_content_text').textContent;
    
    function resetButton() {
        copyButton.textContent = 'Copy';
        copyButton.disabled = false;
        copyButton.style.opacity = 1;
    }

    copyButton.addEventListener('click', function() {
        const textArea = document.createElement('textarea');
        let content = postContentText;

        if (titleRadio.checked) {
            content = '#命令書:\nあなたはプロの編集者です。以下のブログ記事の文章について、より注目や興味を集めやすく、とても魅力的で、SNSで誰もが無視できない強い印象でバズりやすいタイトルにするにはどうすればいいでしょうか？文字数は60文字程度、高校生にもわかりやすく、絵文字を使わない、重要なキーワードを取り残さない、SEOを考慮する、これを条件として、具体的な改善タイトルを５つ提案してください。\n\n #入力文: \n' + content.substring(0, 2300) + '\n\n#出力文:';
        }

        if (summaryRadio.checked) {
            content = '#命令書:\nあなたはプロの編集者です。以下の文章を検索画面でで誰もが無視できずクリックしたくなる印象となるように、絵文字を使わずに、重要なキーワードを取り残さず、SEOを考慮した、ディスクリプションタグに使える要約文を2つ提案してください。\n\n #入力文: \n' + content.substring(0, 2300) + '\n\n#出力文:';
        }

        textArea.value = content;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);

        copyButton.textContent = 'Done';
        copyButton.disabled = true;
        copyButton.style.opacity = 0.5;
    });
    
    noRadio.addEventListener('change', function() {
        resetButton();
    });

    titleRadio.addEventListener('change', function() {
        resetButton();
    });

    summaryRadio.addEventListener('change', function() {
        resetButton();
    });
});
