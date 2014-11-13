main()
{
    compile
    make_golden_master_if_not_exist_yet reference.txt
    run_many_times > output.txt
    diff reference.txt output.txt
}


compile()
{
    xcodebuild -scheme trivia build CONFIGURATION_BUILD_DIR=build
}

make_golden_master_if_not_exist_yet()
{
    local file="$1"
    if test ! -e "$file"; then
        run_many_times > "$file"
    fi
}

run_many_times() {
    for((seed=0;seed<100;seed++)); do
        echo Using seed:$seed
        build/trivia $seed 2>&1 | cut -d "]" -f 2
    done 
}

main
